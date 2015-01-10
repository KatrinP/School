// A simple RPC based Key-Value Storage server and client
package main

import (
	"flag"
	"fmt"
	"os"
)

var (
	help = flag.Bool(
		"help",
		false,
		"Show usage help",
	)
	server = flag.Bool(
		"server",
		true, ///ZDE false původně
		"Start RPC server if true; otherwise start the RPC client",
	)
	lookup = flag.Bool(
		"lookup",
		false,
		"If client, then only perform lookup loop; otherwise insert loop is performed",
	)
	endpoint = flag.String(
		"endpoint",
		"localhost:12110",
		"Endpoint on which server runs or to which client connects",
	)
)

func Usage() {
	fmt.Fprintf(os.Stderr, "Usage: %s [OPTIONS]\n", os.Args[0])
	fmt.Fprintf(os.Stderr, "\nOptions:\n")
	flag.PrintDefaults()
}

func main() {
	flag.Usage = Usage
	flag.Parse()
	
	if *help {
		flag.Usage()
		os.Exit(0)
	}
	if *server {
		fmt.Println("server se připravuje")
		NewKVStore(*endpoint)
	} else {
		clientLoop(*endpoint)
	}
	os.Exit(0)
}

func checkError(err error) {
	if err != nil {
		fmt.Fprintf(os.Stderr, "Fatal error: %s\n", err.Error())
		os.Exit(1)
	}
}
