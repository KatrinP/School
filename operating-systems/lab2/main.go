// +build !solution

// Leave an empty line above this comment.
package main

import (
	"flag"
	"fmt"
	"github.com/uis-dat320-fall2014/labs/lab2/config"
	"os"
)

func main() {
	cfg1 := config.Configuration{1, "hello"}
	if err := cfg1.Save(); err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
	cfg2 := config.Configuration{2, "lab"}
	if err := cfg2.SaveGob(); err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
	fmt.Println(cfg1)
	fmt.Println(cfg2)

	// TODO: Load Configuration objects back from disk
	cfg3, err := config.LoadConfig("config.txt")
	if err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
	fmt.Println("Configuration loaded: ", cfg3)

	//Load Configuration object with Gob
	cfg4, err := config.LoadGobConfig("config.gob")
	if err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
	fmt.Println("Gob configuration loaded: ", cfg4)

	//Use comman line arguments
	namePtr := flag.String("Name", "", "Error: missing Name argument (string) from command line")
	numberPtr := flag.Int("Number", 0, "Error: missing Number argument (integer) from command line")
	if flag.Parse(); err != nil {
		fmt.Println(err)
		os.Exit(1)
	} else {
		fmt.Println("Parsed correctly")
	}
	cfg5 := config.Configuration{*numberPtr, *namePtr}
	if err := cfg5.SaveGob(); err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
	fmt.Println("Configuration with command lines arguments: ", cfg5)
}

