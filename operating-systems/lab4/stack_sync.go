// +build !solution

// Leave an empty line above this comment.
package lab4

import "sync"

type SafeStack struct {
	top  *Element
	size int
	myMu sync.Mutex
}

func (ss *SafeStack) Len() int {
	//ss.myMu.Lock() //here is it not needed because I do not write inte the share variable, right?
	//defer ss.myMu.Unlock()
	return ss.size
}

func (ss *SafeStack) Push(value interface{}) {
	ss.myMu.Lock()
	defer ss.myMu.Unlock()
	ss.top = &Element{value, ss.top}
	ss.size++
}

func (ss *SafeStack) Pop() (value interface{}) {
	if ss.size > 0 {
		ss.myMu.Lock()
		defer ss.myMu.Unlock()
		value, ss.top = ss.top.value, ss.top.next
		ss.size--
		return
	}
	return nil
}
