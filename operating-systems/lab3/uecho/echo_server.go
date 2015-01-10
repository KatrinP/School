// +build !solution

// Leave an empty line above this comment.
package main

import (
	"fmt"
	"net"
	"os"
)


func serverLoop(service string) {
	udpAddr, err := net.ResolveUDPAddr("udp", service)
	checkError(err)
	connec, err := net.ListenUDP("udp", udpAddr)
	checkError(err)
	fmt.Println("Waiting for clients...")
	for {
		handleClient(connec)
	}
}

// Troubleshooting: Note that buf needs to be initialized with a size, since
// otherwise trying to read from the connection will always return n=0 because
// an uninitialized buffer has no space into which data can be stored.
func handleClient(conn *net.Conn) {
	var buf [bsize]byte
	for {
		n, addr, err := conn.ReadFromUDP(buf[0:])
		if err != nil {
			fmt.Fprintf(os.Stderr, "Read error: %s\n", err.Error())
			return
		}
		_, err = conn.WriteToUDP(buf[0:n], addr)
		if err != nil {
			fmt.Fprintf(os.Stderr, "Write error: %s\n", err.Error())
			return
		}
		fmt.Println(string(buf[0:n]))
	}
}
