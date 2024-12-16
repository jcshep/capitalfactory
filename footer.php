<footer class="container">
	<div class="p-45 position-relative">
		<div class="row footer-top">
			<img src="<?php bloginfo('template_directory');?>/img/footer.jpg" alt="" class="w-100 h-100">
			<div class="col-12">
				<div class="spacer-lg"></div>
			</div>
			<div class="col-md-2 mb-5 mb-md-0">
				<div class="tag bd-white">Contact</div>
			</div>
			<div class="col-md-8">
				<div class="display-xl">WE’RE NOT ROCKET SCIENTISTS, BUT WE DO BUSINESS WITH THEM</div>
				<div class="spacer-md"></div>
				<p>Companies, government partners, investors and entrepreneurs. This is where you contact us to find out who needs to contact you.</p>
			</div>
			<div class="col-md-2">
				<a href="" class="btn btn-primary">Contact us</a>
			</div>
			<div class="col-12">
				<div class="spacer-xxl"></div>
			</div>
		</div>
	</div>
	<div class="p-45 position-relative footer-bottom rounded-corners-1">
		<div class="row">
			<div class="col-12 spacer-xxl d-none d-lg-block"></div>
			<div class="col-lg-4 mb-5 mb-lg-0">			
				<a href="<?php bloginfo('url'); ?>">
					<img src="<?php bloginfo('template_directory');?>/img/logo.png" class="logo" alt="">
				</a>
			</div>
			<div class="col-lg-8">
				<div class="grid">
					
					<div>
						<h3>Partnerships</h3>
						<ul>
							<li><a href="">Partnerships Overview</a></li>
							<li><a href="">Sponsorships</a></li>
							<li><a href="">Government</a></li>
							<li><a href="">Innovation Council</a></li>
						</ul>
					</div>
					
					<div>
						<h3>Startups</h3>
						<ul>
							<li><a href="">Startup Overview</a></li>
							<li><a href="">Portfolio / CF Companies</a></li>
							<li><a href="">Company Bios</a></li>
							<li><a href="">Mentors</a></li>
						</ul>
					</div>
					
					<div>
						<h3>Ventures</h3>
						<ul>
							<li><a href="">Ventures Overview</a></li>
							<li><a href="">Texas Fund</a></li>
							<li><a href="">Fellowship Fund</a></li>
							<li><a href="">All Access</a></li>
							<li><a href="">Partners Fund</a></li>
						</ul>
					</div>
					
					<div>
						<h3>Company</h3>
						<ul>
							<li><a href="">Company Overview</a></li>
							<li><a href="">Our Team</a></li>
							<li><a href="">Careers</a></li>
							<li><a href="">CF Portfolio Careers</a></li>
							<li><a href="">Visit Us</a></li>
						</ul>
					</div>
					
					<div>
						<h3>Partnerships</h3>
						<ul>
							<li><a href="">Media Overview</a></li>
							<li><a href="">All Articles</a></li>
							<li><a href="">Video</a></li>
							<li><a href="">Podcast Episodes</a></li>
						</ul>
					</div>

				</div>
			</div>

			<div class="col-12 spacer-xl"></div>

			<div class="col-md-4">
				<ul class="list-unstyled socials p-0 m-0 d-flex align-items-center mb-4 pb-4 pb-md-1">
					<li><a href="" target="_blank"><?= file_get_contents(get_template_directory_uri() . '/img/icon-x.svg'); ?></a></li>
					<li><a href="" target="_blank"><?= file_get_contents(get_template_directory_uri() . '/img/icon-linkedin.svg'); ?></a></li>
					<li><a href="" target="_blank"><?= file_get_contents(get_template_directory_uri() . '/img/icon-instagram.svg'); ?></a></li>
					<li><a href="" target="_blank"><?= file_get_contents(get_template_directory_uri() . '/img/icon-tiktok.svg'); ?></a></li>
				</ul>
				<p class="d-none d-md-block copy">© <?= date('Y'); ?> Capital Factory. All rights reserved. <a href="" target="_blank">Terms</a> & <a href="" target="_blank">Privacy</a>.</p>
			</div>
			<div class="col-md-8">
				<div class="newsletter flex-wrap flex-lg-nowrap rounded-corners-3 text-white d-flex justify-content-between align-items-center">
					<div class="mr-5">
						<h4>Join Capital Factory</h4>
						<p>4,000+ startups already growing with us.</p>
					</div>
					<?= do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>
				</div>
			</div>
			<div class="col-12 d-block d-md-none mt-5 copy">
				<p class="mb-0">© <?= date('Y'); ?> Capital Factory. All rights reserved. <a href="" target="_blank">Terms</a> & <a href="" target="_blank">Privacy</a>.</p>
			</div>
		</div>
	</div>
	<div class="spacer-lg"></div>
</footer>



</div> <!-- wrapper -->

<?php get_template_part('notification/notification'); ?> 
<?php wp_footer(); ?>
</body>
</html>