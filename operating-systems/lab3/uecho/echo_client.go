package main

import (
	"bufio"
	"fmt"
	"io"
	"net"
	"os"
	
)

func clientLoop(service string) {
	addr, err := net.ResolveUDPAddr("udp", service)
	checkError(err)
	conn, err := net.DialUDP("udp", nil, addr)
	checkError(err)
	// close if we exit the loop
	defer conn.Close()
	var buf [bsize]byte
	fmt.Print("Enter: ")
	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		s := scanner.Bytes()
		if string(s) == "exit" {
			// break out if user typed 'exit'
			break
		}
		_, err := conn.Write(s)
		if err != nil {
			fmt.Fprintf(os.Stderr, "Write error: %s\n", err.Error())
			return
		}
		n, err := conn.Read(buf[0:])
		if err != nil {
			if err == io.EOF {
				fmt.Fprintf(os.Stderr, "Connection closed by server: %s\n", conn.RemoteAddr())
			} else {
				fmt.Fprintf(os.Stderr, "Read error: %s\n", err.Error())
			}
			return
		}
		fmt.Println("Server: " + string(buf[0:n]))
		fmt.Print("Enter: ")
	}
	if err := scanner.Err(); err != nil {
		fmt.Fprintln(os.Stderr, "reading standard input:", err)
	}
}
