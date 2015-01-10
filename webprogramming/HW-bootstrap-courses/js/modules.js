/* === Modules class === */

var levels = ["beginner", "intermediate", "advanced"];

/** 
 * Object representing a given module 
 * 
 *   - module_id: unique numeric identifier
 *   - tech:      name of technology (string)
 *   - level:     level of difficulty (1, 2 or 3)
 *   - length:    length of the module in hours
 *   - prereq:    array of module_id-s that are prerequisites for this module
 *   - desc:      description of the module
 */
function Module(module_id, tech, level, length, prereq, desc) {
    this.module_id = module_id;
    this.tech = tech;
    this.level = level;
    this.length = length;
    this.prereq = prereq;
    this.desc = desc;
    
    // get module name in [technology] level [level] format
    this.getName = function() {
        return this.tech + " level " + this.level;
    }
    // get level as string
    this.getLevelString = function() {
        return levels[this.level-1];
    }
    // get length with "hours" appended
    this.getLengthString = function() {
        return this.length + " hours";
    }
}

// modules are stored as an array of module objects
var modules = new Array();

/* === Modules data === */


modules.push(new Module(11, "Girls' dictionary", 1, 2, null, "Basic words and phrases."));
modules.push(new Module(12, "Girls' dictionary", 2, 1, [11], "Advanced understanding."));
modules.push(new Module(21, "Girls' thinking", 1, 3, null, "How the girls' brain works."));
modules.push(new Module(22, "Girls' thinking", 2, 4, [11,21], "Exercises: Think like a girl!"));
modules.push(new Module(23, "Girls' thinking", 3, 2, [22], "Paradoxes and mistakes."));
modules.push(new Module(31, "Girls' behaviour", 1, 2, [21,12], "Basic rules."));
modules.push(new Module(32, "Girls' behaviour", 2, 2, [31], "Difference in behaviour under girls and boys."));
modules.push(new Module(33, "Girls' behaviour", 3, 2, [32,22], "Why girls say 'no'."));
modules.push(new Module(41, "Basic communication", 1, 3, [12,22], "How to start talking with girls."));
modules.push(new Module(42, "Basic communication", 2, 4, [41], "Exercises: Real talk."));
modules.push(new Module(23, "Pick up a girl!", 1, 16, [42, 12, 32], "Basic and advanced tips and trics."));
modules.push(new Module(23, "Forbidden words", 1, 3, [42, 12], "Avoid using bad words."));




