// +build !solution

// Leave an empty line above this comment.
package main

import (
	"fmt"
	"log"
	"net/rpc"
	"strconv"
	"sync"
)

func clientLoop(srvAddr string) {
	// TODO Implement client to that invokes RPC server methods in loop

	client, err := rpc.Dial("tcp", srvAddr)
	if err != nil {
		log.Fatal("dialing:", err)
	}
	var wg sync.WaitGroup
	for a1, a2, a3 := false, false, false; a1 == false || a2 == false || a3 == false; {
		wg.Add(1)
		go func() {
			a1 = mygoroutine(2, client, err)
			defer wg.Done()
		}()
		wg.Add(1)
		go func() {
			a2 = mygoroutine(3, client, err)
			defer wg.Done()
		}()
		wg.Add(1)
		go func() {
			a3 = mygoroutine(5, client, err)
			defer wg.Done()
		}()
		wg.Wait()
	}
}

func mygoroutine(n int, client *rpc.Client, err error) bool {
	for i := 0; i < 50; i++ {
		key := "key nb." + strconv.Itoa(i*n)
		value := "value nb." + strconv.Itoa(i*n)
		pair := Pair{
			Key:   key,
			Value: value}

		var reply *bool //reply tu je pro odpověď, zde je true, pokud to proběhne dobře
		err = client.Call("KVStore.Insert", pair, &reply)
		if err != nil {
			log.Fatal("insert error:", err)
		}
	}

	for i := 0; i < 50; i++ {
		key := "key nb." + strconv.Itoa(i*n)
		var value string
		err = client.Call("KVStore.Lookup", key, &value)
		if err != nil {
			log.Fatal("look-up error:", err)
		}

		if value != "value nb."+strconv.Itoa(i*n) {
			fmt.Println("This value is not correct:", value)
		} else {
			fmt.Println("Value", value, "is ok.")
		}
	}

	var test []string
	err = client.Call("KVStore.Keys", true, &test)
	if err != nil {
		log.Fatal("keys error:", err)
	}
	fmt.Println(len(test))
	for _, i := range test {
		fmt.Println(i)
	}
	return true
}
