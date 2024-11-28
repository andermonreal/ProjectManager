#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define PASSWORD_FILE "password.txt"
#define MAX_PASSWORD_LENGTH 100

int main() {
    char entered_password[MAX_PASSWORD_LENGTH];
    char stored_password[MAX_PASSWORD_LENGTH];
    FILE *file;

    // Leer la contraseña del archivo
    file = fopen(PASSWORD_FILE, "r");
    if (!file) {
        perror("Error opening password file");
        return EXIT_FAILURE;
    }
    if (!fgets(stored_password, MAX_PASSWORD_LENGTH, file)) {
        perror("Error reading password file");
        fclose(file);
        return EXIT_FAILURE;
    }
    fclose(file);

    // Eliminar el salto de línea al final si existe
    stored_password[strcspn(stored_password, "\n")] = '\0';

    // Pedir la contraseña al usuario
    printf("Enter password: ");
    if (!fgets(entered_password, MAX_PASSWORD_LENGTH, stdin)) {
        perror("Error reading input");
        return EXIT_FAILURE;
    }
    entered_password[strcspn(entered_password, "\n")] = '\0';

    // Comparar contraseñas
    if (strcmp(entered_password, stored_password) == 0) {
        printf("Access granted. Opening a root shell...\n");
        system("/bin/sh");
    } else {
        printf("Access denied. Incorrect password.\n");
    }

    return EXIT_SUCCESS;
}
