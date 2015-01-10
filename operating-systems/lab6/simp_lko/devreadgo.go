package main
import (
	"fmt"
	"bufio"
	"os"
)

func main() {
    f, _ := os.Open("/dev/simp_read")
    defer f.Close() 
    scanner := bufio.NewScanner(f)
    if scanner.Scan() {
       fmt.Println("This is what I read from the driver: ", scanner.Text())
    }
}
