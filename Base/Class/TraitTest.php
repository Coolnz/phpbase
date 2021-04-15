<?php

namespace Base\ClassPath;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class TraitTest extends TestCase
{
    use man;
    use woman;

    public function Hiiis()
    {
        echo '!';
    }

    public function test1()
    {
//        $all = new All();
        $this->woman();
        $this->man();
        $this->Hiiis();
    }
}
trait man
{
    public function man()
    {
        echo 'have a dick';
    }
}

trait woman
{
    public function woman()
    {
        echo "don't have a dick";
    }
}
