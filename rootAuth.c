#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <unistd.h>

#define PASSWORD_LENGTH 16

void give_shell() {
    printf("Access granted! Starting root shell...\n");
    setuid(0);
    system("cat /root/root.txt");
    execl("/bin/sh", "sh", NULL);
}

void generate_password(char *password, size_t length) {
    const char charset[] = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    size_t charset_size = sizeof(charset) - 1;
    for (size_t i = 0; i < length; i++) {
        password[i] = charset[rand() % charset_size];
    }
    password[length] = '\0'; 
}

int main() {
    char input[32];
    char correct_password[PASSWORD_LENGTH + 1];
    int is_authenticated = 0;

    srand(time(NULL));
    generate_password(correct_password, PASSWORD_LENGTH);

    printf("Enter password: ");
    gets(input); 

    if (strcmp(input, "securepassword") == 0) {
        is_authenticated = 1;
    }

    if (is_authenticated) {
        give_shell();
    } else {
        printf("Access denied.\n");
    }

    return 0;
}
