<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 30/4/16
 * Time: 9:09 PM
 */

namespace App\Console\Commands;


trait ExecPython
{
    /**
     * Executes Python scripts from the scraper path
     *
     * @param string $script filename of script to evoke. Include .py file extension
     * @param string|array $arguments String or array of arguments to pass to script
     * @return mixed Parsed JSON associative array of the return from the script,
     *               or NULL if there was error parsing
     */
    public function executePython($script, $arguments = '')
    {
        $pythonPath = config('app.python_path');
        $scriptPath = config('app.scraper_path') . '/' .  $script;
        
        if (is_array($arguments))
            $arguments = implode(' ', $arguments);

        $arguments = escapeshellarg($arguments);
        exec("$pythonPath $scriptPath $arguments", $output);
        // TODO: Log error
        return json_decode(implode('', $output), TRUE);
    }
}