<!-- Footer Start -->
</div>
<footer class="footer" style="background-color: #fafbfe;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
            	<div class="footer-links">
                    Powered by <a href="https://github.com/assimon/dujiaoka">@独角数卡.</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-md-block">
                    {!! dujiaoka_config_get('footer') !!}
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="loading">
	<div id="loading-center">
		<div id="loading-center-absolute">
			<div class="object" id="object_one"></div>
			<div class="object" id="object_two"></div>
			<div class="object" id="object_three"></div>
		</div>
	</div>
</div>
</div>
<!-- end Footer -->
<!-- bundle -->

<script src="/assets/hyper/js/vendor.min.js"></script>
<script src="/assets/hyper/js/app.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded',function () {
        $("#loading").fadeOut(1000);
    });
</script>
<script>console.group("Faka");console.log("Name: 独角数卡");console.log("Github: https://github.com/assimon/dujiaoka");console.groupEnd();</script>
<script>console.group("Theme");console.log("Name: Hyper Theme");console.log("Author: Bimoes");console.groupEnd();</script>
</body>
</html>
