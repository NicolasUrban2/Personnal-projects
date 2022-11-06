<?php
    class Maze
    {
        private $maze;
        private $longueurChemin;    // Exit path length
        private $tailleX;   // X size
        private $tailleY;   // Y size
        private $tailleZ;   // Z size
        private $cellSize;
        /**
         *  ^
         *  |
         *  y
         *  z x --->
         * 
         *  ^
         *  |
         *  y
         *  x z --->
         */
        public function getLongueurChemin()
        {
            return $this->getLongueurChemin;
        }

        public function __construct($output, $x, $y, $z, $cellSize)
        {
            $this->tailleX = $x;
            $this->tailleY = $y;
            $this->tailleZ = $z;
            $this->cellSize = $cellSize;

            $this->maze = $this->build_recursive_array(array('y', 'x', 'z'));

            $i=0;
            $t=0;
            // Transform the binary matrix displayed by mazeGenerator.jar into a 4 dimensionnal table
            foreach($output as $line)
            {
                $cells = explode(" ", $line);
                if($i>=$y)  // If we parcoured every line in the current stage
                {
                    $i=0;   // Line 0 of the next stage
                    $t++;   // Next stage
                }
                if($t < $z) // If we haven't passed the last stage, we continue to fill $maze
                {
                    $j=0;
                    foreach($cells as $cell)
                    {
                        $cellArray = str_split($cell);    // Get the 9 booleans from $cell in an array for an easier exploitation
                        $this->maze[$i][$j][$t] = $cellArray;
                        $j++;   // Next cell
                    }
                    $i++;   // Next line
                }
                else    // Else, it is the exit path length
                {
                    $this->longueurChemin = $line;
                }
            }
        }

        // Create a 3 dimensionnal table
        private function build_recursive_array($array)
        {
            if(empty($array) < 1)
            {
                return array();
            } 

            $key = array_shift($array);
            return array($key => build_recursive_array($array));
        }

        // Debug function to display $maze and the exit path length
        public function display()
        {
            $output = "";
            $output = "Path length : ".$this->longueurChemin."<br>";
            for($t=0; $t<$this->tailleZ; $t++)
            {
                $output .= "Stage ".$t." : <br>";
                for($i=0; $i<$this->tailleY; $i++)
                {
                    $output .= "Line ".$i." : ";
                    for($j=0; $j<$this->tailleX; $j++)
                    {
                        foreach($this->maze[$i][$j][$t] as $data)
                        {
                            $output .= $data;
                        }
                        $output .= " ";
                    }
                    $output .= "<br>";
                }
            }
            return $output;
        }

        // Return the code for the svg maze image
        public function buildSVG($afficherSortie)
        {
            $output = "";
            $tailleEspace = $this->cellSize;
            $height = $this->tailleY*$tailleEspace*$this->tailleZ+$tailleEspace*$this->tailleZ+2;
            $width = $this->tailleX*$tailleEspace+4;
            $output .= "<svg height=\"".$height."\" width=\"".$width."\" xmlns=\"http://www.w3.org/2000/svg\">\n";
            $output .= "\t<style> text {font-size :".($tailleEspace/8)."px;} </style>";
            for($t=0; $t<$this->tailleZ; $t++)
            {
                $coordYRedLine;
                if($t > 0)
                {
                    $coordYRedLine = (($this->tailleY*$tailleEspace*$t+(($t-1)*$tailleEspace)+($tailleEspace/4))+$tailleEspace);
                    $output .= "\t<line x1=\"0\" y1=\"".$coordYRedLine."\" x2=\"".($this->tailleX*$tailleEspace)."\" y2=\"".$coordYRedLine."\" stroke=\"red\"/>\n";
                }
                $output .= "\t<text x=\"".($tailleEspace/4)."\" y=\"".(($this->tailleY*$tailleEspace*$t+(($t-1)*$tailleEspace)+($tailleEspace*3/4))+$tailleEspace)."\">Stage ".$t."</text>\n";
                
                for($i=0; $i<$this->tailleY; $i++)
                {
                    for($j=0; $j<$this->tailleX; $j++)
                    {
                        $coordY = ($i*$tailleEspace+($t*$this->tailleY*$tailleEspace)+$t*$tailleEspace)+$tailleEspace;
                        $coordX = ($j*$tailleEspace)+2;
                        if($this->maze[$i][$j][$t][0] == "1")   // If there is a well forward, we add a line to show it
                        {
                            $output .= "\t<line x1=\"".$coordX."\" y1=\"".$coordY."\" x2=\"".($coordX+$tailleEspace)."\" y2=\"".$coordY."\" stroke=\"black\"/>\n";
                        }
                        if($this->maze[$i][$j][$t][1] == "1")   // If there is a wall on the right
                        {
                            $output .= "\t<line x1=\"".($coordX+$tailleEspace)."\" y1=\"".($coordY)."\" x2=\"".($coordX+$tailleEspace)."\" y2=\"".($coordY+$tailleEspace)."\" stroke=\"black\"/>\n";
                        }
                        if($this->maze[$i][$j][$t][2] == "1")   // If there is a wall behind
                        {
                            $output .= "\t<line x1=\"".($coordX)."\" y1=\"".($coordY+$tailleEspace)."\" x2=\"".($coordX+$tailleEspace)."\" y2=\"".($coordY+$tailleEspace)."\" stroke=\"black\"/>\n";
                        }
                        if($this->maze[$i][$j][$t][3] == "1")   // If there is a wall on the left
                        {
                            $output .= "\t<line x1=\"".($coordX)."\" y1=\"".($coordY)."\" x2=\"".($coordX)."\" y2=\"".($coordY+$tailleEspace)."\" stroke=\"black\"/>\n";
                        }
                        if($this->maze[$i][$j][$t][4] == "0")   // If there is no roof wall, we add an arrow
                        {
                            $output .= "\t<line x1=\"".($coordX+(3*$tailleEspace)/4)."\" y1=\"".($coordY+($tailleEspace*3)/4)."\" x2=\"".($coordX+(3*$tailleEspace)/4)."\" y2=\"".($coordY+$tailleEspace/4)."\" stroke=\"black\" />\n";
                            $output .= "\t<line x1=\"".($coordX+(5*$tailleEspace)/8)."\" y1=\"".($coordY+($tailleEspace*3)/8)."\" x2=\"".($coordX+(3*$tailleEspace)/4)."\" y2=\"".($coordY+$tailleEspace/4)."\" stroke=\"black\" />\n";
                            $output .= "\t<line x1=\"".($coordX+(7*$tailleEspace)/8)."\" y1=\"".($coordY+($tailleEspace*3)/8)."\" x2=\"".($coordX+(3*$tailleEspace)/4)."\" y2=\"".($coordY+$tailleEspace/4)."\" stroke=\"black\" />\n";
                        }
                        if($this->maze[$i][$j][$t][5] == "0")   // If there is no ground wall
                        {
                            $output .= "\t<line x1=\"".($coordX+(3*$tailleEspace)/4)."\" y1=\"".($coordY+($tailleEspace*3)/4)."\" x2=\"".($coordX+(3*$tailleEspace)/4)."\" y2=\"".($coordY+$tailleEspace/4)."\" stroke=\"black\" />\n";
                            $output .= "\t<line x1=\"".($coordX+(5*$tailleEspace)/8)."\" y1=\"".($coordY+($tailleEspace*5)/8)."\" x2=\"".($coordX+(3*$tailleEspace)/4)."\" y2=\"".($coordY+($tailleEspace*3)/4)."\" stroke=\"black\" />\n";
                            $output .= "\t<line x1=\"".($coordX+(7*$tailleEspace)/8)."\" y1=\"".($coordY+($tailleEspace*5)/8)."\" x2=\"".($coordX+(3*$tailleEspace)/4)."\" y2=\"".($coordY+($tailleEspace*3)/4)."\" stroke=\"black\" />\n";
                        }
                        if($afficherSortie) // If we want to display the exit path (the solution of the maze)
                        {
                            if($this->maze[$i][$j][$t][6] == "1")   // If the cell is part of the exit path
                            {
                                $output .= "\t<circle cx=\"".($coordX+($tailleEspace/2))."\" cy=\"".($coordY+($tailleEspace/2))."\" r=\"".($tailleEspace/10)."\" stroke=\"blue\" fill=\"blue\"/>\n";
                            }
                        }
                        if($this->maze[$i][$j][$t][7] == "1")   // If the cell is the entry
                        {
                            $output .= "\t<text x=\"".($coordX+($tailleEspace/8))."\" y=\"".($coordY+($tailleEspace/4))."\">IN</text>\n";
                        }
                        if($this->maze[$i][$j][$t][8] == "1")   // If the cell is the exit
                        {
                            $output .= "\t<text x=\"".($coordX+($tailleEspace/8))."\" y=\"".($coordY+($tailleEspace/4))."\">OUT</text>\n";
                        }
                    }
                }
            }
            $output .= "</svg>\n";
            return $output;
        }
    }
?>