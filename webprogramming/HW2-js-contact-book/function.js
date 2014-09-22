function Contact(firstname, lastname, tel, email) {
    this.firstname = firstname;
    this.lastname = lastname;
    this.tel = tel;
    this.email = email;
    this.display = true;
}

var frankie = new Contact("Franken", "Stein", "123 456 789", "frankenstein@castle.com");
var dracula = new Contact("Count", "Dracula", "111 222 333", "dracula@count.com");
var devil = new Contact("Lucifer","Devil", "666 666 666", "devil@hell.com");
var babajaga = new Contact("Baba", "Jaga", "987 654 321", "jaga@baba.com");

if (document.cookie.indexOf("contactBook") >= 0) {
    var contactBook = $.parseJSON($.cookie("contactBook"));
    }
else {
    var contactBook = [];
    contactBook.push(frankie);
    contactBook.push(dracula);
    contactBook.push(devil);
    contactBook.push(babajaga);
    $.cookie("contactBook", JSON.stringify(contactBook));
}  

function printContact(Contact,i) {
    if (contactBook[i].display == true) {
        my_id = "contact"+i;
   
        var contactDiv = document.createElement('li');
        contactDiv.setAttribute('class', 'contact');
        contactDiv.setAttribute('id', my_id);
        document.getElementById("contactList").appendChild(contactDiv);
        
        var contactName = document.createElement('h2');
        contactName.setAttribute('class', 'contactName');
        contactName.setAttribute('id', 'contactName'+i);
        contactName.innerHTML = contactBook[i].firstname + " " + contactBook[i].lastname;
        document.getElementById(my_id).appendChild(contactName);
        
        var formDel = document.createElement('button');
        formDel.setAttribute('name', 'delContact');
        formDel.setAttribute('id', 'delContact'+i);
        formDel.setAttribute('class', 'mybutton');
        formDel.setAttribute('onClick', 'deleteContact("'+my_id+'");');
        document.getElementById('contactName'+i).appendChild(formDel);
        
        var icondelete = document.createElement('i');
        icondelete.setAttribute('class', 'fa fa-trash deleteContact');
        icondelete.setAttribute('id', 'delete'+i);
        document.getElementById('delContact'+i).appendChild(icondelete);
        
         var formEdit = document.createElement('button');
        formEdit.setAttribute('name', 'editContact');
        formEdit.setAttribute('id', 'editContact'+i);
        formEdit.setAttribute('class', 'mybutton');
        formEdit.setAttribute('onClick', 'editContact("'+my_id+'");');
        document.getElementById('contactName'+i).appendChild(formEdit);
        
        var iconedit = document.createElement('i');
        iconedit.setAttribute('class', 'fa fa-pencil editContact');
        iconedit.setAttribute('id', 'delete'+i);
        document.getElementById('editContact'+i).appendChild(iconedit);
        
        var contactTel = document.createElement('p');
        contactTel.setAttribute('class', 'contactTel');
        contactTel.setAttribute('id', 'contactTel'+i);
        contactTel.innerHTML = contactBook[i].tel;
        document.getElementById(my_id).appendChild(contactTel);
        
        var contactEmail = document.createElement('a');
        contactEmail.setAttribute('class', 'contactTel');
        contactEmail.setAttribute('id', 'contactTel'+i);
        contactEmail.setAttribute('href', 'mailto:'+contactBook[i].email)
        contactEmail.innerHTML = contactBook[i].email;
        document.getElementById(my_id).appendChild(contactEmail);
    }
}


function printBook() {
    contactBook = $.parseJSON($.cookie("contactBook"));
    for (var i = 0; i < contactBook.length; i++) {
        if (contactBook[i].display == false) {
            showall = document.createElement("a");
            showall.innerHTML = "Show all";
            showall.setAttribute('onclick', 'return myFind("")');
            document.getElementById("searchSort").appendChild(showall);
            break;
        }
    }
    for (var i = 0; i < contactBook.length; i++) {
        printContact(contactBook[i], i);
    }
}

function addContact() {
    if($( "#placeForForm" ).hasClass( "visible" )){
        $("#placeForForm").removeClass("visible");    
    }else{
        $("#placeForForm").addClass("visible");
    }
}



function submitForm(form) {
        
        var firstname = document.addContact.firstname.value;
        var lastname = document.addContact.lastname.value;
        var telephon = document.addContact.telephon.value;
        var email = document.addContact.email.value; 
        
        valid = validateForm(firstname, telephon, email);
        
        if (valid == true) {
        
            var newContact = new Contact(firstname, lastname, telephon, email);
            contactBook.push(newContact); 
            printContact(newContact, contactBook.length-1);
            $.cookie("contactBook", JSON.stringify(contactBook));
            return true;
        }
        return false;    
}
function deleteContact(id) {
    userchoice = confirm("Do you want really delete this scary contact?");
    if (userchoice == true) {
        var regexp = /\d\d*/;
        var index = id.match(regexp);
        contactBook.splice(index,1);
        $.cookie("contactBook", JSON.stringify(contactBook));
        location.reload ();
    }    
    return true;
}

function findContact(form) {
    var searchText = document.searchform.searchtext.value;
    myFind(searchText);
}

function myFind(searchText) {
    searchText.toLowerCase();
    var regexp = new RegExp(searchText);
    for (var i = 0; i < contactBook.length; i++) {
        if (contactBook[i].firstname.toLowerCase().match(regexp) == null && 
            contactBook[i].lastname.toLowerCase().match(regexp) == null && 
            contactBook[i].tel.toLowerCase().match(regexp) == null && 
            contactBook[i].email.toLowerCase().match(regexp) == null
            ) {
            contactBook[i].display = false;
            $.cookie("contactBook", JSON.stringify(contactBook));
        }
        else {
            contactBook[i].display = true;
            $.cookie("contactBook", JSON.stringify(contactBook));
        }
    }
    location.reload ();
}

function submitEditForm(form,index) {
        var firstname = document.editContact.firstname.value;
        var lastname = document.editContact.lastname.value;
        var telephon = document.editContact.telephon.value;
        var email = document.editContact.email.value; 
        
        var valid = validateForm(firstname, telephon, email);
        if (valid == true) {
        
            contactBook[index].firstname = firstname;
            contactBook[index].lastname = lastname;
            contactBook[index].tel = telephon;
            contactBook[index].email = email;
            
            $.cookie("contactBook", JSON.stringify(contactBook));
            location.reload ();
            return true;
        }
        return false;
}



function editContact(id) {
    var regexp = /\d\d*/;
    var index = id.match(regexp);

    var myForm = document.createElement('form');
        myForm.setAttribute('name', 'editContact');
        myForm.setAttribute('id', 'editContact');
        myForm.setAttribute('onSubmit', 'return submitEditForm(this.form,'+index+')');
        document.getElementById('contact'+index).appendChild(myForm);
        
     var firstname = document.createElement('input');
         firstname.setAttribute('type','text');
         firstname.setAttribute('name','firstname');
         firstname.setAttribute('placeholder','First name');
         firstname.setAttribute('value',contactBook[index].firstname);
         document.getElementById("editContact").appendChild(firstname);
         
      var lastname = document.createElement('input');
         lastname.setAttribute('type','text');
         lastname.setAttribute('name','lastname');
         lastname.setAttribute('placeholder','Last name');
         lastname.setAttribute('value',contactBook[index].lastname);
         document.getElementById("editContact").appendChild(lastname);
         
      var telephon = document.createElement('input');
         telephon.setAttribute('type','text');
         telephon.setAttribute('name','telephon');
         telephon.setAttribute('placeholder','Phone number');
         telephon.setAttribute('value',contactBook[index].tel);
         document.getElementById("editContact").appendChild(telephon); 
     
     var email = document.createElement('input');
         email.setAttribute('type','text');
         email.setAttribute('name','email');
         email.setAttribute('placeholder','E-mail');
         email.setAttribute('value',contactBook[index].email);
         document.getElementById("editContact").appendChild(email);     
     
     var editButton = document.createElement('input');
         editButton.setAttribute('type','submit');
         editButton.setAttribute('name','addButton');
         editButton.setAttribute('value', 'Edit contact');
         document.getElementById("editContact").appendChild(editButton);
}


function validateForm(firstname, tel, email) {
    if (firstname == null || firstname == "") {
        alert("First name of your scary friend must be filled in");
        return false;
    }

    if ((tel == "" || tel == null) && (email == "" || email == null)) {
        alert("Please fill in at least telephon or e-mail of your scary friend");
        return false;
    }
    else {
        if (tel != "" && tel != null) {
            var reTel = /^[\d\+\- ]+$/;
            var telFound = tel.match(reTel);
            if (telFound == "" || telFound == null) {
                alert("Phone number of your scary friend is in wrong format");
                return false;
            }
        }
        if (email != "" && email != null) {
            var reEmail = /^\w+@\w+\...+$/;
            var mailFound = email.match(reEmail);
            if (mailFound == "" || mailFound == null) {
                alert("E-mail of your scary friend is in wrong format");
                return false;
            }
        }
    }
    return true;
}

function sortByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key]; var y = b[key];
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
}

function mysort(form) {
    var sortingoption = document.sorting.selectSort.value;
    sortByKey(contactBook, sortingoption);
    $.cookie("contactBook", JSON.stringify(contactBook));
    location.reload ();
    return true;
    
}

printBook();
document.getElementById("addContactButton").onclick = function() {
    addContact();
    
};


