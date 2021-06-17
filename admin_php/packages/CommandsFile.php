<?php

class CommandsFile
{
    public static function write($txt)
    {
        $file = fopen('../assets/commands/linux_commands/command.c', 'w');
        fwrite($file, ' #include <stdio.h>');
        fwrite($file, ' #include <stdlib.h>');
        fwrite($file, ' int main(void) {');

        if (is_array($txt)) {
            foreach ($txt as $t) {
                fwrite($file, ' system("' . $t . '");');
            }
        } else {
            fwrite($file, ' system("' . $txt . '");');
        }

        fwrite($file, '}');
        fclose($file);
    }
}
