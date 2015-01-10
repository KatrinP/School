// +build !solution

// Leave an empty line above this comment.
package zaplab

import (
	"time"
	"strings"
	"net"
	"fmt"
	"strconv"
)

const timeFormat = "2006/01/02, 15:04:05"
const dateFormat = "2006/01/02"
const timeOnly = "15:04:05"
const timeLen = len(timeFormat)

type StatusChange struct {
	Time time.Time
	//either volume, Mute_Status or HDMI_Status
	Status string
	//Depending of Status may have different values
	ValueRange int
	//TODO finish this struct (1p)
}

type ChZap struct {
	Time time.Time
	//Date time.Time
	IP net.IP
	FromChan string
	ToChan string
	
	//TODO finish this struct (1p)
	
}

func NewSTBEvent(event string) (*ChZap, *StatusChange, error) {
	splitted_event := strings.Split(event, ",")	//mozna pridat mezeru za carku?
	if len(splitted_event) == 5 {
		date_and_time := strings.Join(splitted_event[0:2], ", ")
		my_date, _ := time.Parse(timeFormat, date_and_time)
		ip := net.ParseIP(strings.TrimSpace(splitted_event[2]))
		if ip == nil {
			fmt.Println("chyba v ip")
			fmt.Println(splitted_event[2])
		}
		from_chan := splitted_event[3]
		to_chan := splitted_event[4]


		return &ChZap{my_date, ip, from_chan, to_chan}, new(StatusChange), nil	
	} else if len(splitted_event) == 4 {

		unParsedTime := strings.Join(splitted_event[0:2], ", ")
		date, err := time.Parse(timeFormat, unParsedTime)
	        if err != nil {
				fmt.Println(err)
	        }
		//ip := net.ParseIP(strings.TrimSpace(splitted_event[2])) //will we need it?
		whole_status := splitted_event[3]
		valueS := strings.Split(whole_status, ": ") 
		stat := valueS[0]
		Value, err := strconv.Atoi(valueS[1])
		return new(ChZap), &StatusChange{date, stat, Value}, nil	
	
	} else {
		err := fmt.Errorf("something went wrong")
		return new(ChZap), new(StatusChange), err 
	}
}

func (zap ChZap) String() string {
	//TODO write this method (2p)
		time := zap.Time.Format(timeFormat)
		ip := " " + zap.IP.String()
	return time + ip + zap.FromChan + zap.ToChan
}

func (schg StatusChange) String() string {
	//TODO write this method (1p)
		time := schg.Time.Format(timeFormat)
		val := " " + strconv.Itoa(schg.ValueRange)
	return time + schg.Status + val
}

// The duration between receiving (this) zap event and the provided event
func (zap ChZap) Duration(provided *ChZap) time.Duration { //added *!
	//TODO write this method (1p)
//		my_duration := zap.Time //- provided.Time
	//	fmt.Println(my_duration)
	duration := zap.Time.Sub(provided.Time)
	if duration < 0 {
		return provided.Time.Sub(zap.Time)
	}
	return duration

}

/*func (zap ChZap) Date() string {
	//TODO write this method (1p)
	return ""
}*/
