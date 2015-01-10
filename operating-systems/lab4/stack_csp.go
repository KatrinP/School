package lab4

import (
	"flag"
	"log"
	"os"
	"runtime/pprof"
)

type CspStack interface {
	Push(interface{})
	Pop() interface{}
	Len() int
}

type safeStack chan cmdStruct

type cmdStruct struct {
	action  cmdAction
	element interface{}
	result  chan<- interface{}
	data    chan<- UnsafeStack
}

type cmdAction int

const (
	end cmdAction = iota
	pop
	push
	length
)

var cpuprofile = flag.String("cpuprofile", "", "write cpu profile to file")

func (ss safeStack) Len() int {
	myreply := make(chan interface{})
	ss <- cmdStruct{action: length, result: myreply}
	return (<-myreply).(int)
}

func (ss safeStack) Push(element interface{}) {
	ss <- cmdStruct{action: push, element: element}
}

func (ss safeStack) Pop() (value interface{}) {
	myreply := make(chan interface{})
	ss <- cmdStruct{action: pop, result: myreply}
	result := <-myreply
	return result
}

func NewCspStack() CspStack {
	ss := make(safeStack)
	go ss.run()
	return ss
}

func (ss safeStack) run() {

	flag.Parse()
	if *cpuprofile != "" {
		f, err := os.Create(*cpuprofile)
		if err != nil {
			log.Fatal(err)
		}
		pprof.StartCPUProfile(f)
		defer pprof.StopCPUProfile()
	}

	stack := new(UnsafeStack)
	for cmd := range ss {
		switch cmd.action {
		case push:
			stack.Push(cmd.element)
		case pop:
			cmd.result <- stack.Pop()
		case length:
			cmd.result <- stack.Len()
		case end:
			close(ss)
			cmd.data <- *stack
		}
	}
}
