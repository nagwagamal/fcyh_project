	<!-- core scripts -->
<!--    <script src="./assets/plugins/jquery-1.11.1.min.js"></script>-->
    <script src="./assets/bootstrap/js/bootstrap.js"></script>
    <script src="./assets/plugins/jquery.slimscroll.min.js"></script>
    <script src="./assets/plugins/jquery.easing.min.js"></script>
    <script src="./assets/plugins/appear/jquery.appear.js"></script>
    <script src="./assets/plugins/jquery.placeholder.js"></script>
    <script src="./assets/plugins/fastclick.js"></script>
    <!-- /core scripts -->

    <!-- page level scripts -->
    <script src="./assets/plugins/jquery.blockUI.js"></script>
    <script src="./assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="./assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="./assets/plugins/jquery.sparkline.js"></script>
    <script src="./assets/plugins/flot/jquery.flot.js"></script>
    <script src="./assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="./assets/plugins/count-to/jquery.countTo.js"></script>

    <!-- /page level scripts -->

    <!-- page script -->
	{if is_array($footJs)}
	{foreach from=$footJs item="c"}<script type="text/javascript" src="./assets/js/{$c}?v={$pagetime}"></script>
	{/foreach}
	{else}
		{$footJs}
	{/if}
    <!-- /page script -->

    <!-- template scripts -->
    <script src="./assets/js/offscreen.js"></script>

    <script src="./assets/js/main.js"></script>
    <!-- /template scripts -->
