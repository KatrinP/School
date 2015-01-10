/* === Helper functions === */

/**
 * Find a module by module_id
 * @param {type} module_id
 * @returns {Module}
 */
function getModule(module_id) {
// The modules array is indexed with numbers,
// but we need to be able to look up modules by their ID.
// This is something that should be done with associative arrays (hashes), 
// but those are a bit tricy in JS... So we keep it simple for now.
    for (var i = 0; i < modules.length; i++) {
        if (modules[i].module_id == module_id) { //I was lazy and change === to ==
            return modules[i];
        }
    }
    return null;
}

/**
 * Generate modules data to be used in DataTables
 * @returns {modulesToTable.dataset|Array}
 */
function modulesToTable() {

    var dataset = [];
    for (var i = 0; i < modules.length; i++) {
        var m = modules[i];
        // generate a list of prerequisites
        var prereq = "none";
        if (m.prereq !== null) {
            // collect names of prerequisites
            prereq_names = [];
            for (var j = 0; j < m.prereq.length; j++) {
                prereq_module = getModule(m.prereq[j]);
                if (prereq_module !== null) {
                    prereq_names.push(prereq_module.getName());
                }
            }
            prereq = prereq_names.join(", ");
        }
        
        dataset.push([m.getName(), m.getLevelString(), m.getLengthString(), m.desc, prereq]);
    }
    return dataset;
}


/* === jQuery code === */
$(document).ready(function () {

    if ($('#main').length > 0) {
        // code to run on the main page
    }

    if ($('#modules').length > 0) {
        // code to run on the modules page
        
        print_modules(modules, true);
        $(document).ready(function(){
            $('#modules_table').DataTable();
        });
    }

    if ($('#course').length > 0) {
        // code to run on the course page

        print_modules(modules, false);
       
        $(document).ready(function(){
            var all_prereq = {};
            var added_modules = [];
            var my_class = "progress-bar-success";
            var course_length = $("#course_length option:selected").val();
            $('#course_length').change(function(){
                course_length = $("#course_length option:selected").val();
            })
            
            $('#modules_table').DataTable(); 
            $('input[name="selected_course"]').click(function(){
                module_id = $(this).val();
                module = getModule(module_id);  
                all_prereq[module.tech] = module.prereq;
                if (this.checked) {
                    if (is_empty(all_prereq)) {
                        my_class = "progress-bar-success";
                    }
                    else {
                        if (module.prereq == null) {
                            my_class = "progress-bar-success";
                        }
                        else {
                            my_class = "progress-bar-success";
                            for (prereq in module.prereq) {
                                 if (($.inArray(module.prereq[prereq], added_modules)) == -1){
                                     my_class = "progress-bar-danger";
                                     break;
                                 }
                            }
                        }
                    }    
                    added_modules.push(Number(module_id));
                    $('#progress_bar').append('<div class="progress-bar '+ my_class +'" id="'+ module_id +'" style="width: '+ (module.length/course_length)*100 +'%">'+ module.getName() +'</div>');

                     my_class = "progress-bar-success";
                }
                else {
                    $('#'+ module_id +'').remove();
                    delete all_prereq[module.tech];
                    var index = added_modules.indexOf(module_id);
                    added_modules.splice(index, 1);
                }
            })        
        });
    } 
});


function print_modules(modules, no_checkboxes) {
        for (i = 0; i < modules.length; i++) {                                
            $(document).ready((function(module){
                return function(){
                    var prerequisites = "";
                    if (module.prereq != null) {
                        for (j = 0; j < module.prereq.length; j++) {
                            var result = $.grep(modules, function(e){ return e.module_id == module.prereq[j]; });
                            if (result.length > 0) {
                                prerequisites += result[0].getName() + ", ";
                            }
                        }
                    }
                    if (prerequisites == "") {
                        prerequisites = "none";
                    }
                    if (no_checkboxes) {
                        $('#modules_table').append("<tr><td>"+ module.getName() +"</td><td>"+ module.getLevelString() +"</td><td>"+ module.getLengthString() +"</td><td>"+ module.desc +"</td><td>"+ prerequisites +"</td></tr>");
                    }
                    else {

                        $('#modules_table tbody').append("<tr><td><form><input type='checkbox' name='selected_course' value="+ module.module_id +"></input></form></td><td>"+ module.getName() +"</td><td>"+ module.getLevelString() +"</td><td>"+ module.getLengthString() +"</td><td>"+ module.desc +"</td><td>"+ prerequisites +"</td></tr>");
                    }
                }    
            })(modules[i]))   
        } 
}


function is_empty(associative_array) {
   for(var key in associative_array) {
      if (associative_array.hasOwnProperty(key)) {
         return false;
      }
   }
   return true;
}
