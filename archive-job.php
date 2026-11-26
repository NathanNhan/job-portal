<?php
get_header();

$search_keyword = isset($_GET['job_keyword']) && is_scalar($_GET['job_keyword']) ? sanitize_text_field(wp_unslash($_GET['job_keyword'])) : '';
$search_location = isset($_GET['job_location']) && is_scalar($_GET['job_location']) ? sanitize_text_field(wp_unslash($_GET['job_location'])) : '';
$search_category = isset($_GET['job_category']) && is_scalar($_GET['job_category']) ? sanitize_title(wp_unslash($_GET['job_category'])) : '';

add_action('pre_get_posts', function ($query) {
	if (is_admin() || empty($query->query_vars['job_search'])) {
		return;
	}

	$query->set('post_type', 'job');
	$query->set('post_status', 'publish');
	$query->set('posts_per_page', 10);

	$keyword = isset($_GET['job_keyword']) && is_scalar($_GET['job_keyword']) ? sanitize_text_field(wp_unslash($_GET['job_keyword'])) : '';
	if ($keyword !== '') {
		$query->set('s', $keyword);
	}

	$location = isset($_GET['job_location']) && is_scalar($_GET['job_location']) ? sanitize_text_field(wp_unslash($_GET['job_location'])) : '';
	if ($location !== '') {
		$query->set('meta_query', array(
			array(
				'key'     => 'location',
				'value'   => $location,
				'compare' => 'LIKE',
			),
		));
	}

	$category = isset($_GET['job_category']) && is_scalar($_GET['job_category']) ? sanitize_title(wp_unslash($_GET['job_category'])) : '';
	if ($category !== '') {
		$query->set('tax_query', array(
			array(
				'taxonomy' => 'job_category',
				'field'    => 'slug',
				'terms'    => $category,
			),
		));
	}
});

$job_query = new WP_Query(array(
	'post_type'      => 'job',
	'post_status'    => 'publish',
	'posts_per_page' => 10,
	'paged'          => max(1, get_query_var('paged')),
	'job_search'     => true,
));

$pagination_args = array_filter(array(
	'job_keyword'  => $search_keyword,
	'job_location' => $search_location,
	'job_category' => $search_category,
));
?>

<main class="job-archive section">
	<div class="container">
		<header class="job-archive__header">
			<p class="job-eyebrow"><?php esc_html_e('Find your next opportunity', 'job-portal'); ?></p>
			<h1><?php post_type_archive_title(); ?></h1>
			<p><?php esc_html_e('Explore jobs that match your skills and career goals.', 'job-portal'); ?></p>
		</header>

		<div class="job-results-heading">
			<h2><?php esc_html_e('Available opportunities', 'job-portal'); ?></h2>
			<p><?php
				printf(
					esc_html(_n('%s job found', '%s jobs found', (int) $job_query->found_posts, 'job-portal')),
					esc_html(number_format_i18n($job_query->found_posts))
				);
			?></p>
		</div>

		<?php if ($job_query->have_posts()) : ?>
			<div class="job-listings">
				<?php while ($job_query->have_posts()) : $job_query->the_post(); ?>
					<?php
					$job_location = get_post_meta(get_the_ID(), 'location', true);
					$job_categories_for_post = get_the_terms(get_the_ID(), 'job_category');
					?>
					<article <?php post_class('job-listing-card'); ?>>
						<a class="job-listing-card__main" href="<?php the_permalink(); ?>">
							<?php if (has_post_thumbnail()) : ?>
								<div class="job-listing-card__image"><?php the_post_thumbnail('thumbnail'); ?></div>
							<?php else : ?>
								<div class="job-listing-card__image job-listing-card__image--placeholder" aria-hidden="true">
									<i class="lni-briefcase"></i>
								</div>
							<?php endif; ?>
							<div class="job-listing-card__content">
								<h3><?php the_title(); ?></h3>
								<div class="job-listing-card__meta">
									<?php if ($job_location) : ?>
										<span><i class="lni-map-marker" aria-hidden="true"></i><?php echo esc_html($job_location); ?></span>
									<?php endif; ?>
									<?php if (!empty($job_categories_for_post) && !is_wp_error($job_categories_for_post)) : ?>
										<span><i class="lni-layers" aria-hidden="true"></i><?php echo esc_html($job_categories_for_post[0]->name); ?></span>
									<?php endif; ?>
								</div>
								<p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
							</div>
						</a>
						<a class="job-listing-card__link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(sprintf(__('View %s', 'job-portal'), get_the_title())); ?>">
							<i class="lni-arrow-right" aria-hidden="true"></i>
						</a>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			$pagination = paginate_links(array(
				'total'     => $job_query->max_num_pages,
				'current'   => max(1, get_query_var('paged')),
				'type'      => 'list',
				'add_args'  => $pagination_args,
				'prev_text' => esc_html__('Previous', 'job-portal'),
				'next_text' => esc_html__('Next', 'job-portal'),
			));
			if ($pagination) :
			?>
				<nav class="job-pagination" aria-label="<?php esc_attr_e('Job pages', 'job-portal'); ?>">
					<?php echo wp_kses_post($pagination); ?>
				</nav>
			<?php endif; ?>
		<?php else : ?>
			<div class="job-empty-state">
				<span class="job-empty-state__icon"><i class="lni-search" aria-hidden="true"></i></span>
				<h2><?php esc_html_e('No jobs match your search', 'job-portal'); ?></h2>
				<p><?php esc_html_e('Try adjusting your keywords, location, or category.', 'job-portal'); ?></p>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php
wp_reset_postdata();
get_footer();