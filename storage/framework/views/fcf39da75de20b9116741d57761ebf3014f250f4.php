<?php $__env->startSection('content'); ?>

<h2>Search Result</h2>
<code id="dataDisplay" class="language-json">Video Results</code>
<div id="overlay"><img src="http://localhost/brightcove/loading.gif" alt="Be patient..." /></div>
     
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>