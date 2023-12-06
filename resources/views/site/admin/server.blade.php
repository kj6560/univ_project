@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="card mb-4">
        <h5 class="card-header">Server Details</h5>
        <div class="card-body">
            <div class="mb-3 row">
                <p>🌡️ RAM Usage: <span class="result big"><?php echo $memusage; ?>%</p>
                <p>🖥️ CPU Usage: <span class="result big"><?php echo $cpuload; ?>%</p>
                <p>💽 Hard Disk Usage: <?php echo $diskusage; ?>%</p>
                <p>🖧 Established Connections: <?php echo $connections; ?></p>
                <p>🖧 Total Connections: <?php echo $totalconnections; ?></p>
            </div>
            <div class="mb-3 row">
                <p>🖥️ CPU Threads: <?php echo $cpu_count; ?></p>
            </div>
            <div class="mb-3 row">
                <p>🌡️ RAM Total: <?php echo $memtotal; ?> GB </p>
                <p>🌡️ RAM Used: <?php echo $memused; ?> GB </p>
                <p>🌡️ RAM Available: <?php echo $memavailable; ?> GB </p>
            </div>
            <div class="mb-3 row">
                <p>💽 Hard Disk Free: <?php echo $diskfree; ?> GB </p>
                <p>💽 Hard Disk Used: <?php echo $diskused; ?> GB </p>
                <p>💽 Hard Disk Total: <?php echo $disktotal; ?> GB </p>
            </div>
            <div class="mb-3 row">
                <p>📟 Server Name: <?php echo $_SERVER['SERVER_NAME']; ?> </p>
                <p>💻 Server Addr: <?php echo $_SERVER['SERVER_ADDR']; ?> </p>
                <p>🌀 PHP Version: <?php echo phpversion(); ?> </p>
                <p>🏋️ PHP Load: <?php echo $phpload; ?> GB </p>

                <p>⏱️ Load Time: <?php echo $total_time; ?> sec</p>
            </div>
        </div>
    </div>
</div>


@stop