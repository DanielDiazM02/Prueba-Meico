<?php

if (!defined('ABSPATH')) exit;

global $wpdb;

$per_page = 10;
$current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
$offset = ($current_page - 1) * $per_page;

$total = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}discount_log");
$total_pages = ceil($total / $per_page);

$logs = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}discount_log ORDER BY created_at DESC LIMIT %d OFFSET %d",
    $per_page,
    $offset
));

$base_url = admin_url('admin.php?page=discount-assessment-logs');
?>

<div class="wrap">
    <h1>Discount Logs</h1>
    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Order ID</th>
                <th>Discount Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logs)): ?>
                <tr><td colspan="5">No logs found.</td></tr>
            <?php else: ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo esc_html($log->id); ?></td>
                        <td><?php echo esc_html($log->user_id); ?></td>
                        <td><?php echo esc_html($log->order_id); ?></td>
                        <td><?php echo esc_html($log->discount_amount); ?></td>
                        <td><?php echo esc_html($log->created_at); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($total_pages > 1): ?>
    <div class="tablenav bottom">
        <div class="tablenav-pages">
            <span class="displaying-num"><?php echo esc_html($total); ?> items</span>
            <span class="pagination-links">
                <?php if ($current_page > 1): ?>
                    <a class="first-page button" href="<?php echo esc_url(add_query_arg('paged', 1, $base_url)); ?>">&laquo;</a>
                    <a class="prev-page button" href="<?php echo esc_url(add_query_arg('paged', $current_page - 1, $base_url)); ?>">&lsaquo;</a>
                <?php else: ?>
                    <span class="first-page button disabled">&laquo;</span>
                    <span class="prev-page button disabled">&lsaquo;</span>
                <?php endif; ?>

                <span class="paging-input">
                    <?php echo esc_html($current_page); ?> of <span class="total-pages"><?php echo esc_html($total_pages); ?></span>
                </span>

                <?php if ($current_page < $total_pages): ?>
                    <a class="next-page button" href="<?php echo esc_url(add_query_arg('paged', $current_page + 1, $base_url)); ?>">&rsaquo;</a>
                    <a class="last-page button" href="<?php echo esc_url(add_query_arg('paged', $total_pages, $base_url)); ?>">&raquo;</a>
                <?php else: ?>
                    <span class="next-page button disabled">&rsaquo;</span>
                    <span class="last-page button disabled">&raquo;</span>
                <?php endif; ?>
            </span>
        </div>
    </div>
    <?php endif; ?>
</div>
