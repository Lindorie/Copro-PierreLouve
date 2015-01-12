$(window).load(function() {
	$(document).ready(function() {
		$('.diaporama')
			.jcarousel(
				{
					wrap: 'circular'
				})
			.jcarouselAutoscroll(
				{
			       target: '+=1',
			       interval: 3000
				}
			);

		$('.diaporama-pagination')
			.on('jcarouselpagination:active', 'a', function() {
				$(this).addClass('active');
			})
			.on('jcarouselpagination:inactive', 'a', function() {
				$(this).removeClass('active');
			})
			.jcarouselPagination({
				'item': function(page) {
					return '<a class="page" href="#' + page + '">' + page + '</a>';
				}
			});
	});
});