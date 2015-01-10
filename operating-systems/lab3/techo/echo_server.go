package main

import (
	"fmt"
	"io"
	"net"
	"os"
)

func serverLoop(service string) {
	tcpAddr, err := net.ResolveTCPAddr("tcp", service)
	checkError(err)
	listener, err := net.ListenTCP("tcp", tcpAddr)
	checkError(err)
	fmt.Println("Waiting for clients...")
	for {
		conn, err := listener.Accept()
		if err != nil {
			continue
		}
		go handleClient(conn)
	}
}

// Troubleshooting: Note that buf needs to be initialized with a size, since
// otherwise trying to read from the connection will always return n=0 because
// an uninitialized buffer has no space into which data can be stored.
func handleClient(conn net.Conn) {
	defer conn.Close()
	var buf [bsize]byte
	for {
		n, err := conn.Read(buf[0:])
		if err != nil {
			if err == io.EOF {
				fmt.Fprintf(os.Stderr, "Connection closed by: %s\n", conn.RemoteAddr())
			} else {
				fmt.Fprintf(os.Stderr, "Read error: %s\n", err.Error())
			}
			return
		}
		_, err = conn.Write(buf[0:n])
		if err != nil {
			fmt.Fprintf(os.Stderr, "Write error: %s\n", err.Error())
			return
		}
		fmt.Println(string(buf[0:n]))
	}
}
