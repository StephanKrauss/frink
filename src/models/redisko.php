<?php

namespace models;

/**
 * Mapperklasse zur NoSQL Redis.
 *
 * @author vodolaz095 https://www.upwork.com/freelan
 * @author Stephan Krauß
 * @date 27.04.2016
 * @tutorial
 * @file redisko.php
 * @spackage model
 */

class redisko
{
    protected static $instance;

    private $sock;
    private $stats=array();
    private $is_auth=false;

    /**
     * Start Redisko
     *
     * @return mixed
     */
    public static function s()
    {
        // $red = redisko::init();
        $redisko = self::init();

        return $redisko->stats;
    }

    /*
    * Singleton get instanse
    */
    private static function init()
    {
        if (is_null(self::$instance))
        {
            self::$instance = new redisko();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $timeout = ini_get("default_socket_timeout");
        $errno = null;
        $errstr = null;

        if (defined('REDIS_DSN'))
        {
            if ($arr = parse_url(REDIS_DSN))
            {
                if ($arr['scheme'] == 'redis')
                {
                    $this->sock = @fsockopen($arr['host'], $arr['port'], $errno, $errstr, $timeout);
                }
                else
                {
                    throw new \Exception('REDIS connecting error - wrong REDIS_DSN format! Required redis://redishost:6379 where 6379 is porn number');
                }

            }
        }
        elseif (defined('REDIS_SOCKET'))
        {
            $this->sock=@fsockopen(REDIS_SOCKET, null, $errno, $errstr, $timeout);
        }
        else
        {
            $this->sock=@fsockopen('localhost', 6379, $errno, $errstr, $timeout);
        }

        if ($this->sock === FALSE)
        {
            throw new \Exception('REDIS connecting error:'.$errno.':'.$errstr);
        }

    }

    function __destruct()
    {
        fclose($this->sock);
    }


    function __call($name, $args)
    {

        $start=microtime(true);
        array_unshift($args, strtoupper($name));

        $command=sprintf('*%d%s%s%s', count($args), CRLF, implode(array_map(function($arg)
        {
            return sprintf('$%d%s%s', strlen($arg), CRLF, $arg);
        }, $args), CRLF), CRLF);

        for ($written=0; $written < strlen($command); $written+=$fwrite)
        {
            $fwrite=fwrite($this->sock, substr($command, $written));

            if ($fwrite===FALSE)
            {
                throw new \Exception('Failed to write entire command ("'.$command.'") to stream!');
            }
        }

        $a=$this->readResponse();

        if (is_array($a))
        {
            $type='Multi-Bulk';
        }
        elseif ($a===true)
        {
            $type='OK';
        }
        elseif ($a)
        {
            $type='Bulk/Integer';
        }
        else
        {
            $type='Empty';
        }

        $this->stats[]=array('command'=> trim(implode(' ',$args)),
                             'time'   =>(1000*round((microtime(true)-$start), 6)),
                             'type'   =>$type);
        return $a;
    }


    private function readResponse()
        {
            /* Parse the response based on the reply identifier */
            $reply=trim(fgets($this->sock, 512));
            switch (substr($reply, 0, 1))
            {
                /* Error reply */
                case '-':
                    throw new \Exception(trim(substr($reply, 4)));
                    break;
                /* Inline reply */
                case '+':
                    $response=substr(trim($reply), 1);
                    if ($response==='OK')
                        {
                            $response=TRUE;
                        }
                    break;
                /* Bulk reply */
                case '$':
                    $response=NULL;
                    if ($reply=='$-1')
                        {
                            break;
                        }
                    $read=0;
                    $size=intval(substr($reply, 1));
                    if ($size>0)
                        {
                            do
                                {
                                    $block_size=($size-$read)>1024 ? 1024 : ($size-$read);
                                    $r=fread($this->sock, $block_size);
                                    if ($r===FALSE)
                                        {
                                            throw new \Exception('Failed to read response from stream');
                                        }
                                    else
                                        {
                                            $read+=strlen($r);
                                            $response.=$r;
                                        }
                                } while ($read<$size);
                        }
                    fread($this->sock, 2); /* discard crlf */
                    break;
                /* Multi-bulk reply */
                case '*':
                    $count=intval(substr($reply, 1));
                    if ($count=='-1')
                        {
                            return NULL;
                        }
                    $response=array();
                    for ($i=0; $i<$count; $i++)
                        {
                            $response[]=$this->readResponse();
                        }
                    break;
                /* Integer reply */
                case ':':
                    $response=intval(substr(trim($reply), 1));
                    break;

                default:
                    die($reply);
                    //throw new \Exception('Unknown response: ' . $reply);
                    break;
            }
            /* Party on */
            return $response;
        }

    /**
     * ruft die Methode von Redis auf
     *
     * @param $name
     * @param array $args
     * @return mixed
     */
    static function __callStatic($name, $args=array())
    {
        $redisko = redisko::init();

        if (defined('REDIS_PWD') and !$redisko->is_auth)
        {
            if ($redisko->auth(REDIS_PWD))
                {
                    $redisko->is_auth=true;
                }
        }

        return call_user_func_array(array($redisko, $name), $args);
    }


}