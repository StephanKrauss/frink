<?php

namespace models;

/**
 * Little Ini Parser
 *
 * LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category Little
 * @package Little_Ini_Parser
 * @copyright Copyright (c) 2008-2020 Nikishaev Andrey (http://andreynikishaev.livejournal.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @version 1.1
 */

class iniparser {

        protected $declared = false;

        /**
         * Loads configuration from the configuration files
         *
         * @param string $pathes - pathes to the configuration files
         * @param string $sep_k - key separator string
         * @param string $sep_v - value separator string
         * @return array - parsed configuration the configuration files
         */

        public function parse($pathes)
		{
            $allConf = array();

            foreach($pathes as $path){
                $conf = $this->getArray($path);
				$allConf= array_merge($allConf, $conf);
            }

            return $allConf;
        }

        /**
         * Loads configuration from the configuration file
         * and returns the associative array
         *
         * @param string $path - path to the configuration file
         * @param string $sep_k - key separator string
         * @param string $sep_v - value separator string
         * @return array - parsed configuration
         */

        protected function getArray($path)
		{
            $conf = parse_ini_file($path,true);

            return $conf;

        }
}
