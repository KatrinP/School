// +build !solution

// Leave an empty line above this comment.
package config

import (
	"fmt"
	"regexp"
	"strconv"
)

type MyError struct {
	Content string
}

func (c *Configuration) parse(line string) (err error) {
	err = run(line, c)
	return err
<<<<<<< HEAD
=======
}
func (e *MyError) Error() string {
	return fmt.Sprintf("There is something wrong with this text: %s", e.Content)
}

func run(line string, c *Configuration) error {
	if line == "" {
		return nil
	}
	re := regexp.MustCompile("(.+)=(.+)")
	found_string := re.FindStringSubmatch(line) //FindString(line)

	if found_string[0] != "" {
		if found_string[1] == "Number" {
			c.Number, _ = strconv.Atoi(found_string[2])
		} else {
			if found_string[1] == "Name" {
				c.Name = found_string[2]
			}
		}
	} else {
		return &MyError{
			line,
		}
	}
	return nil
>>>>>>> b225372d64974aa83dda725188dd420c969a3dbc
}
func (e *MyError) Error() string {
	return fmt.Sprintf("There is something wrong with this text: %s", e.Content)
}

func run(line string, c *Configuration) error {
	if line == "" {
		return nil
	}
	re := regexp.MustCompile("(.+)=(.+)")
	found_string := re.FindStringSubmatch(line) //FindString(line)

	if found_string[0] != "" {
		if found_string[1] == "Number" {
			c.Number, _ = strconv.Atoi(found_string[2])
		} else {
			if found_string[1] == "Name" {
				c.Name = found_string[2]
			}
		}
	} else {
		return &MyError{
			line,
		}
	}
	return nil
}

// TODO: find keys=value in line
//       and store value to the correct part of the c object
// TIPS: strconv.Atoi()

//	return nil //return nil, když to je v pořádku, jinak string s chybovou hláškou
//}
