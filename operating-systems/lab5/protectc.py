import threading
from time import sleep
import argparse

# parse the command line arguments
# --help for help
parser = argparse.ArgumentParser()
parser.add_argument("-wop", "--without-protection", help="Without lock for threads...",
                    action="store_false", dest="locked", default=False)
parser.add_argument("-wp", "--with-protection", help="With lock for threads",
                    action="store_true", dest="locked", default=False)
parser.add_argument("-t", "--threads", help="Number of threads", type=int, default=10)
parser.add_argument("-a", "--accesses", help="Number of accesses", type=int, default=10)
args = parser.parse_args()

# our constants:
number_access = args.accesses
number_threads = args.threads
is_locked = args.locked  # with/without protection ~ true/false

# number of correct and incorrect operations during threading
correct = 0
violations = 0

# global source
g = 0

# a lock for the threads
lock = threading.Lock()


def main():
    threads = create_threads(number_threads, number_access)
    start_thread(threads)
    wait_for_threads(threads)
    compare_result(number_threads*number_access)


# we add and subtract (number_access times) the thread number from our global source g
# so it should be the same as in the beginning
def do_something_clever(i, number_access):
    global g
    global correct
    global violations
    print("Running thread %d/%d. " % (i+1, number_threads))

    for j in range(0, number_access):
        myg = g
        #sleep(0.01)  # wait a while :) especially on my laptop...
        g += i
        #sleep(0.01)
        g -= i
        if myg == g:
            #print("g: %d is identical to myg: %d" % (g, myg))
            correct += 1
        else:
            #print("g: %d is not identical to myg: %d" % (g, myg))
            violations += 1

    print("Ending thread %d/%d. " % (i+1, number_threads))


# simply test, if we should use lock or not and go on with doing something clever
def test_lock(i, number_access):
    if is_locked:
        with lock:
            do_something_clever(i, number_access)
    else:
        do_something_clever(i, number_access)


def create_threads(number_threads, number_access):
    threads = []
    for i in range(0, number_threads):
        threads.append(threading.Thread(target=test_lock, args=(i, number_access)))
    return threads


def start_thread(threads):
    for thread in threads:
        thread.start()


def wait_for_threads(threads):
    for thread in threads:
        thread.join()


def compare_result(expected_result):
    print("Number of correct: %d (should be %d), number of violations: %d" % (correct, expected_result, violations))

    if expected_result == correct:
        print("OK")
    else:
        print("FAIL")

# run main:
main()