#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>
#include <getopt.h>

//global variables:
pthread_mutex_t lock;
static int asmMutex  = 1;
int g = 0;
int correct = 0;
int violations = 0;

//default values, can be changed by commmand line flags:
int number_threads = 10;
int number_access = 10;
int is_locked = 0;
int is_assembly = 0;

//declaration of function:
void do_something_clever(int i);
void test_lock(void * i);
void compare_result(int expected_result);
int parse_command_line (int argc, char **argv);
void show_help(void);

//main:
int main (int argc, char *argv[]) {
    int err;
    int i;
    int * attr = (int *)malloc((number_threads+1) * sizeof(int));
    pthread_t * threads = malloc(sizeof(pthread_t)*number_threads);

    parse_command_line(argc, argv);
    printf("Number of threads: %d, number od access: %d, with-protection: %d, with assembly: %d\n", number_threads,number_access, is_locked, is_assembly);

    for (i = 0; i < number_threads; i++) {
        *(attr++) = i;
        err = pthread_create(&threads[i], NULL, (void* (*)(void*))test_lock, (void *)attr);
            if (err != 0)
                printf("I can't create thread :[%d]\n", err);
    }
    for (i = 0; i < number_threads; i++) {
        pthread_join(threads[i], NULL);
    }

    //expected result: every access in every thread should give correct result
    compare_result(number_threads * number_access);
    free(attr - number_threads);
    free(threads);
    return 0;
}


void do_something_clever(int i){
   printf("Thread %d/%d running.\n",  i+1, number_threads);

   int j;
   for (j = 0; j < number_access; j++) {
        int myg;
        myg = g;
        sleep(0);
        //I have used sleep(1) for my laptop, because I got no FAIL in the other case...
        //or I had to encrease the number of accesses...
        g += i;
        sleep(0);
        g -= i;
        if (myg == g) {
            //printf("g: %d is identical to myg: %d\n" % (g, myg));
            correct++;
        }
        else {
            //printf("g: %d is not identical to myg: %d\n" % (g, myg));
            violations++;
        }
    }

    printf("Thread %d/%d ending.\n", i+1, number_threads);
//    pthread_exit(0);
}


//To lock with assembly
void assembly_lock() {
    asm("spin: lock btr $0, asmMutex");
    asm("jnc spin");
}

//To unlock with assembly
void assembly_unlock() {
    asm("bts $0, asmMutex");
}

// simply test, if we should use lock or not (and which one)
void test_lock(void * i) {
    int x = *((int*) i);

    if (is_assembly) {
            assembly_lock();
            do_something_clever(x);
            assembly_unlock();
    }
    else if (is_locked) {
            pthread_mutex_lock(&lock);
            do_something_clever(x);
            pthread_mutex_unlock(&lock);
        }
        else {
            do_something_clever(x);
        }
}

void compare_result(int expected_result) {
    printf("Number of correct: %d (should be %d), number of violations: %d \n", correct, expected_result, violations);
    if (expected_result == correct) {
        printf("OK\n");
    }
    else printf("FAIL\n");
}

void show_help(void) {
    printf("Usage: protect [--threads NUMBER_OF_THREADS] [--access NUMBER_OF_ACCESS] [--with-protection] [--without-protection] [--assembly]\n\n");
    printf("Optional arguments:\n--help\tshow this help message and exit\n");
    printf("--threads\tNumber of threads\n");
    printf("--accesses\tNumber of accesses\n");
    printf("--with-protection\tWith lock for threads...\n");
    printf("--without-protection\tWithout lock for threads...\n");
    printf("--assembly\tWith assembly lock for threads...\n");
}

int parse_command_line (int argc, char **argv){
    static struct option long_options[] = {
        {"threads", required_argument, NULL, 't'},
        {"accesses", required_argument, NULL, 'a'},
        {"with-protection", no_argument, NULL, 'w'},
        {"without-protection", no_argument, NULL, 'o'},
        {"assembly", no_argument, NULL, 's'},
        {"help", no_argument, NULL, 'h'},
        {NULL, 0, NULL, 0}
    };

    char ch;
    while ((ch = getopt_long(argc, argv, "t:a:wosh", long_options, NULL)) != -1) {
        switch (ch)
        {
             case 't':
                 number_threads = atoi(optarg);
                 break;
             case 'a':
                 number_access = atoi(optarg);
                 break;
             case 'w':
                is_locked = 1;
                break;
             case 'o':
                is_locked = 0;
                break;
             case 's':
                is_assembly = 1;
                break;
             case 'h':
                show_help();
                exit(0);
                break;
             
        }
    }
    return 0;
}
