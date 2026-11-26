<?php
$application_notice = '';
$application_error = '';
$job_id = get_queried_object_id();

if (
	'POST' === (isset($_SERVER['REQUEST_METHOD']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_METHOD'])) : '')
	&& isset($_POST['job_application_submit'])
) {
	$nonce = isset($_POST['job_application_nonce']) && is_string($_POST['job_application_nonce']) ? sanitize_text_field(wp_unslash($_POST['job_application_nonce'])) : '';
	if (!wp_verify_nonce($nonce, 'submit_job_application_' . $job_id)) {
		$application_error = __('Your session could not be verified. Please refresh the page and try again.', 'job-portal');
	} else {
		$applicant_name = isset($_POST['applicant_name']) && is_string($_POST['applicant_name']) ? sanitize_text_field(wp_unslash($_POST['applicant_name'])) : '';
		$applicant_email = isset($_POST['applicant_email']) && is_string($_POST['applicant_email']) ? sanitize_email(wp_unslash($_POST['applicant_email'])) : '';

		if ($applicant_name === '' || !is_email($applicant_email)) {
			$application_error = __('Enter your name and a valid email address.', 'job-portal');
		} elseif (
			!isset($_FILES['cv']) || !is_array($_FILES['cv']) || empty($_FILES['cv']['name'])
			|| !isset($_FILES['cv']['error'], $_FILES['cv']['size'], $_FILES['cv']['tmp_name'])
			|| !is_string($_FILES['cv']['name']) || !is_string($_FILES['cv']['tmp_name'])
			|| !is_scalar($_FILES['cv']['error']) || !is_scalar($_FILES['cv']['size'])
			|| UPLOAD_ERR_OK !== (int) $_FILES['cv']['error']
		) {
			$application_error = __('Choose a PDF CV to upload.', 'job-portal');
		} elseif ((int) $_FILES['cv']['size'] > 5 * MB_IN_BYTES) {
			$application_error = __('Your PDF must be smaller than 5 MB.', 'job-portal');
		} else {
			$file_check = wp_check_filetype_and_ext(
				$_FILES['cv']['tmp_name'],
				sanitize_file_name(wp_unslash($_FILES['cv']['name']))
			);

			if ('pdf' !== $file_check['ext'] || 'application/pdf' !== $file_check['type']) {
				$application_error = __('Only PDF files are accepted.', 'job-portal');
			} else {
				if (!function_exists('wp_handle_upload')) {
					require_once ABSPATH . 'wp-admin/includes/file.php';
				}

				$upload = wp_handle_upload($_FILES['cv'], array(
					'test_form' => false,
					'mimes'     => array('pdf' => 'application/pdf'),
				));

				if (!empty($upload['error'])) {
					$application_error = __('The CV could not be uploaded. Please try again.', 'job-portal');
				} else {
					$author_id = (int) get_post_field('post_author', $job_id);
					$recipient = $author_id ? get_the_author_meta('user_email', $author_id) : '';
					if (!is_email($recipient)) {
						$recipient = get_option('admin_email');
					}

					$subject = sprintf(__('Job application: %s', 'job-portal'), get_the_title($job_id));
					$message = sprintf(
						__("New application for: %1\$s\nApplicant: %2\$s\nEmail: %3\$s", 'job-portal'),
						get_the_title($job_id),
						$applicant_name,
						$applicant_email
					);
					$headers = array('Reply-To: ' . $applicant_name . ' <' . $applicant_email . '>');
					$mail_sent = wp_mail($recipient, $subject, $message, $headers, array($upload['file']));

					if (is_file($upload['file']) && !unlink($upload['file'])) {
						error_log('Job Portal: could not remove temporary CV after application email.');
					}

					if ($mail_sent) {
						$application_notice = __('Your application has been sent successfully.', 'job-portal');
					} else {
						$application_error = __('We could not send your application right now. Please try again later.', 'job-portal');
					}
				}
			}
		}
	}
}

get_header();
?>

<main class="single-job section">
	<div class="container">
		<?php while (have_posts()) : the_post(); ?>
			<?php
			$job_location = get_post_meta(get_the_ID(), 'location', true);
			$job_skills = get_post_meta(get_the_ID(), 'skills', true);
			$job_categories = get_the_terms(get_the_ID(), 'job_category');
			?>
			<?php if ($application_notice) : ?>
				<div class="job-application-alert job-application-alert--success" role="status"><?php echo esc_html($application_notice); ?></div>
			<?php elseif ($application_error) : ?>
				<div class="job-application-alert job-application-alert--error" role="alert"><?php echo esc_html($application_error); ?></div>
			<?php endif; ?>

			<div class="single-job__layout">
				<article class="single-job__content">
					<header class="single-job__header">
						<?php if (has_post_thumbnail()) : ?>
							<div class="single-job__company-image"><?php the_post_thumbnail('medium'); ?></div>
						<?php else : ?>
							<div class="single-job__company-image single-job__company-image--placeholder" aria-hidden="true">
								<i class="lni-briefcase"></i>
							</div>
						<?php endif; ?>
						<div>
							<p class="job-eyebrow"><?php esc_html_e('Job opportunity', 'job-portal'); ?></p>
							<h1><?php the_title(); ?></h1>
							<div class="single-job__meta">
								<?php if ($job_location) : ?>
									<span><i class="lni-map-marker" aria-hidden="true"></i><?php echo esc_html($job_location); ?></span>
								<?php endif; ?>
								<?php if (!empty($job_categories) && !is_wp_error($job_categories)) : ?>
									<span><i class="lni-layers" aria-hidden="true"></i><?php echo esc_html($job_categories[0]->name); ?></span>
								<?php endif; ?>
								<span><i class="lni-calendar" aria-hidden="true"></i><?php echo esc_html(get_the_date()); ?></span>
							</div>
						</div>
					</header>

					<section class="single-job__section">
						<h2><?php esc_html_e('About this role', 'job-portal'); ?></h2>
						<div class="single-job__description"><?php the_content(); ?></div>
					</section>

					<?php if ($job_skills) : ?>
						<section class="single-job__section">
							<h2><?php esc_html_e('Skills and requirements', 'job-portal'); ?></h2>
							<div class="single-job__skills"><?php echo wp_kses_post(wpautop($job_skills)); ?></div>
						</section>
					<?php endif; ?>
				</article>

				<aside class="single-job__sidebar">
					<div class="job-apply-card">
						<p class="job-eyebrow"><?php esc_html_e('Interested in this role?', 'job-portal'); ?></p>
						<h2><?php esc_html_e('Take the next step', 'job-portal'); ?></h2>
						<p><?php esc_html_e('Send your details and CV directly to the job poster.', 'job-portal'); ?></p>
						<button class="button job-apply-button" type="button" data-open-application>
							<?php esc_html_e('Apply for this job', 'job-portal'); ?>
						</button>
						<p class="job-apply-card__note"><?php esc_html_e('PDF CV only · Maximum file size 5 MB', 'job-portal'); ?></p>
					</div>
				</aside>
			</div>

			<dialog class="job-application-dialog" aria-labelledby="job-application-title" <?php echo $application_error ? 'data-auto-open="true"' : ''; ?>>
				<div class="job-application-dialog__header">
					<div>
						<p class="job-eyebrow"><?php esc_html_e('Application', 'job-portal'); ?></p>
						<h2 id="job-application-title"><?php esc_html_e('Apply for this job', 'job-portal'); ?></h2>
					</div>
					<button class="job-application-dialog__close" type="button" aria-label="<?php esc_attr_e('Close application form', 'job-portal'); ?>" data-close-application>&times;</button>
				</div>
				<p class="job-application-dialog__intro"><?php esc_html_e('Add your contact details and attach your CV as a PDF.', 'job-portal'); ?></p>
				<?php if ($application_error) : ?>
					<p class="job-application-alert job-application-alert--error" role="alert"><?php echo esc_html($application_error); ?></p>
				<?php endif; ?>
				<form class="job-application-form" method="post" enctype="multipart/form-data">
					<?php wp_nonce_field('submit_job_application_' . $job_id, 'job_application_nonce'); ?>
					<label for="applicant-name"><?php esc_html_e('Full name', 'job-portal'); ?></label>
					<input id="applicant-name" name="applicant_name" type="text" autocomplete="name" required>

					<label for="applicant-email"><?php esc_html_e('Email address', 'job-portal'); ?></label>
					<input id="applicant-email" name="applicant_email" type="email" autocomplete="email" required>

					<label for="applicant-cv"><?php esc_html_e('CV (PDF, max 5 MB)', 'job-portal'); ?></label>
					<input id="applicant-cv" name="cv" type="file" accept=".pdf,application/pdf" required>

					<button class="button job-apply-button" type="submit" name="job_application_submit" value="1">
						<?php esc_html_e('Send application', 'job-portal'); ?>
					</button>
				</form>
			</dialog>
		<?php endwhile; ?>
	</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var dialog = document.querySelector('.job-application-dialog');
	if (!dialog) {
		return;
	}

	document.querySelectorAll('[data-open-application]').forEach(function (button) {
		button.addEventListener('click', function () {
			dialog.showModal();
		});
	});

	dialog.querySelectorAll('[data-close-application]').forEach(function (button) {
		button.addEventListener('click', function () {
			dialog.close();
		});
	});

	if (dialog.dataset.autoOpen === 'true') {
		dialog.showModal();
	}
});
</script>

<?php get_footer(); ?>