package main
import (
	"fmt"
	"bufio"
	"os"
)

func main() {
	if len(os.Args) <= 1 {
		f,_ := os.Open("/dev/simp_write")
		defer f.Close()
		scanner := bufio.NewScanner(f)
		if scanner.Scan() {
			fmt.Println(scanner.Text())
		}	 
	} else {
		msg := os.Args[1]
		f,err := os.OpenFile("/dev/simp_write", os.O_APPEND|os.O_WRONLY, 0600)
		if err != nil {
			panic(err)
		}
		defer f.Close()
	        if _, err = f.WriteString(msg + "\n"); err != nil {
			panic(err)
		} 
	}
}
	
