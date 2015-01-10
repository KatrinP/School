// +build !solution

// Leave an empty line above this comment.
package main

import (
	"net"
	"net/rpc"
)

func NewKVStore(srvAddr string) {
	listener, err := net.Listen("tcp", srvAddr)
	checkError(err)

	kv := &KVStore{store: make(map[string]string)}
	rpc.Register(kv)
	rpc.Accept(listener)
}
