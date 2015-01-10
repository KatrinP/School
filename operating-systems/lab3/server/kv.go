// +build !solution

// Leave an empty line above this comment.
package main

import "fmt"
import "sync"

type Pair struct {
	Key, Value string
}

type KVStore struct {
	sync.RWMutex
	store map[string]string
}

func (kv *KVStore) Insert(input Pair, reply *bool) error {
	kv.Lock()
	kv.store[input.Key] = input.Value
	kv.Unlock()
	*reply = true
	return nil
}

func (kv *KVStore) Lookup(key string, val *string) error {
	kv.RLock()

	if v, ok := kv.store[key]; ok {
		*val = v
	} else {
		*val = fmt.Sprintf("key '%s' not found", key)
	}
	kv.RUnlock()
	return nil
}

func (kv *KVStore) Keys(dummy bool, keys *[]string) error {
	if dummy == true {
		kv.RLock()
		for key, _ := range kv.store {
			*keys = append(*keys, key)
		}
		kv.RUnlock()
	}	
	return nil
}
