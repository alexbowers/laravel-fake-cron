# Laravel Fake Cron

---

`php artisan cron` is a daemon command that runs the `schedule:run` command.

Use this package instead of adding `php artisan schedule:run` to your crontab file.

Run this command under supervisor so that it will automatically restart should any crash occur.

Options:
---

You can use the `--interval` flag to set the interval between `schedule:run` calls.

By default, this is every 60 seconds, however it can be changed to any interger second value.

`php artisan cron --interval=15` would run the scheduled commands every 15 seconds.

This is helpful if you want a finer granuality than a typical cron gives you.

By default this command outputs a progress bar showing how long until the next trigger, if you do not want this (eg, in production), use the `--quiet` flag.