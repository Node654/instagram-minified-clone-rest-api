<?php

namespace App\Enums;

enum SubscribedState: string
{
    case Subscribed = 'subscribed';
    case Unsubscribed = 'unsubscribed';
}
