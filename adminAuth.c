#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/types.h>

/*
 * Project Manager :: internal admin access tool
 *
 * Small helper monre uses to open an administrative shell after
 * checking an access code. Installed setuid (owner: monre) so the
 * on-call team can use it without knowing monre's password.
 *
 * TODO(monre): harden the input handling. The access code must
 * never be longer than 31 characters.
 */

void open_admin_shell(void)
{
    uid_t uid = geteuid();
    gid_t gid = getegid();

    /* Become the owner (monre) fully, then hand over a shell. */
    setregid(gid, gid);
    setreuid(uid, uid);

    printf("\n[+] Access code accepted. Launching admin shell...\n");
    fflush(stdout);
    execl("/bin/bash", "bash", "-p", (char *) NULL);
    perror("execl");
}

int main(void)
{
    struct {
        char code[32];
        int  authorized;
    } ctx;

    ctx.authorized = 0;

    printf("=== Project Manager :: Admin Access Verification ===\n");
    printf("Enter your access code: ");
    fflush(stdout);

    /*
     * BUG: reads far more bytes than 'code' can hold. Anything past
     * the 32nd byte spills into the adjacent 'authorized' field, so a
     * long enough input flips the check without a valid code
     * (CWE-121: stack-based buffer overflow).
     */
    read(0, ctx.code, 100);

    if (ctx.authorized != 0) {
        open_admin_shell();
    } else {
        printf("[-] Access denied.\n");
    }

    return 0;
}
