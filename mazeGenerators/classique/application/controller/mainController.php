<?php
    class mainController
    {
        public static function formulaire($request, $context)
        {
            return context::SUCCESS;
        }

        // Create an object of type Maze with the informations from the form
        public static  function generateMaze($request, $context)
        {
            $errorDetected = false;
            $errorMessage = "";
            // Verify informations quality from the form
            if(key_exists("tailleX", $request) && key_exists("tailleY", $request) && key_exists("tailleZ", $request) && key_exists("coordX", $request) && key_exists("coordY", $request) && key_exists("coordZ", $request))
            {
                if($request['tailleX'] > 100 || $request['tailleX'] < 1 || $request['tailleY'] > 100 || $request['tailleY'] < 1 || $request['tailleZ'] > 100 || $request['tailleZ'] < 1)
                {
                    $errorMessage = $errorMessage . " Sizes must be between 1 and 100.";
                    $errorDetected = true;
                }
                if($request['coordX'] >= $request['tailleX'] || $request['coordX'] < 0 || $request['coordY'] >= $request['tailleY'] || $request['coordY'] < 0 || $request['coordZ'] >= $request['tailleZ'] || $request['coordZ'] < 0)
                {
                    $errorMessage = $errorMessage . " Entry coordinates are incompatibles with the given sizes.";
                    $errorDetected = true;
                }

                if(!$errorDetected)
                {
                    $output;
                    /**
                     * The maze generator is a .jar file (made by myself). Return a matrix filled with binary numbers recupered in 
                     * $output.
                     */
                    exec("java -jar java/mazeGenerator.jar ".$request['tailleX']." ".$request['tailleY']." ".$request['tailleZ']." ".$request['coordX']." ".$request['coordY']." ".$request['coordZ'], $output);
                    $cellSize = 80; // Default value of cell sizes (used in Maze::buildSVG())
                    if(key_exists("cellSize", $request))
                    {
                        if($request['cellSize'] >= 10 && $request['cellSize'] <= 100)
                        {
                            $cellSize=$request['cellSize'];
                        }
                    }
                    $maze = new Maze($output, $request['tailleX'], $request['tailleY'], $request['tailleZ'], $cellSize);
                    $context->maze = $maze;
                    return context::SUCCESS;
                }
            }
            else
            {
                $errorMessage = $errorMessage . " All fields must be filled.";
            }
            $context->error = $errorMessage;
            return context::ERROR;
        }

        public static function showMazeWithSoluce($request, $context)
        {
            return context::SUCCESS;
        }

        public static function showMazeWithoutSoluce($request, $context)
        {
            return context::SUCCESS;
        }
    }
?>