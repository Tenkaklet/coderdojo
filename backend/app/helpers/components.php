<?php
foreach (glob(HELPERS_PATH."components/*.php") as $filename)
{
    include $filename;
}