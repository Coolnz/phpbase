<?php
//namespace

class OrderContext
{
}
interface State
{
    public function proceedToNext(OrderContext $context);

    public function toString(): string;
}

class StateCreated implements State
{
    public function proceedToNext(OrderContext $context)
    {
        $context->setState(new StateShipped());
    }

    public function toString(): string
    {
        return 'created';
    }
}

class StateDone implements State
{
    public function proceedToNext(OrderContext $context)
    {
        // TODO: Implement proceedToNext() method.
    }

    public function toString(): string
    {
        return 'done';
    }
}

class StateShipped implements State
{
    public function proceedToNext(OrderContext $context)
    {
        $context->setState(new StateDone());
    }

    public function toString(): string
    {
        return 'shipped';
    }
}
