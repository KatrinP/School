// A simple TCP based echo client and server.
package main

import (
	"flag"
	"fmt"
	"os"
	
)

const bsize = 512

var (
	help = flag.Bool(
		"help",
		false,
		"Show usage help",
	)
	server = flag.Bool(
		"server",
		false,
		"Start echo server if true; otherwise start the echo client",
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
		serverLoop(*endpoint)
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
