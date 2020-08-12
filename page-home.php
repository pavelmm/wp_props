<?php
/*
Template Name: Главная
*/
?>
<?php $page_id = get_the_ID(); ?>
<?php get_header(); ?>


<!-- section-top -->
<?php
$top_img_id = carbon_get_post_meta($page_id, 'top_img');
$top_img_src = wp_get_attachment_image_url($top_img_id, 'full');
$top_img_src_webp = convertToWebpSrc($top_img_src);
?>
<section class="section-top lazy" data-src="<?php echo $top_img_src_webp; ?>" data-src-replace-webp="<?php echo $top_img_src; ?>">
  <div class="container section-top__container">
    <p class="section-top__info"><?php echo carbon_get_post_meta($page_id, 'top_info'); ?></p>
    <h1 class="section-top__title"><?php echo carbon_get_post_meta($page_id, 'top_title'); ?></h1>
    <div class="section-top__btn">
      <button class="btn" type="button" data-scroll-to="<?php echo carbon_get_post_meta($page_id, 'top_btn_scroll_to'); ?>"><?php echo carbon_get_post_meta($page_id, 'top_btn_text'); ?></button>
    </div>
  </div>
</section>
<!-- /.section-top -->

<?php

?>


<!-- section-catalog -->
<section class="section section-catalog js-section-catalog" id="section-catalog">
  <div class="container">
    <header class="section__header">
      <h2 class="page-title page-title--accent"><?php echo carbon_get_post_meta($page_id, 'catalog_title'); ?></h2>
      <nav class="catalog-nav">

        <?php
        $catalog_nav = carbon_get_post_meta($page_id, 'catalog_nav');
        $catalog_nav_ids = wp_list_pluck($catalog_nav, 'id');

        $catalog_nav_items = get_terms([
          'include' => $catalog_nav_ids,
        ]);
        ?>
        <ul class="catalog-nav__wrapper">
          <li class="catalog-nav__item">
            <button class="catalog-nav__btn is-active" type="button" data-filter="all">все</button>
          </li>

          <?php foreach ($catalog_nav_items as $item) : ?>
            <li class="catalog-nav__item">
              <button class="catalog-nav__btn" type="button" data-filter="<?php echo $item->slug; ?>"><?php echo $item->name; ?></button>
            </li>
          <?php endforeach; ?>

        </ul>
      </nav>
    </header>

    <?php
    $catalog_products = carbon_get_post_meta($page_id, 'catalog_products');
    $catalog_products_ids = wp_list_pluck($catalog_products, 'id');

    $catalog_products_args = [
      'post_type' => 'product',
      'post__in' => $catalog_products_ids
    ];
    $catalog_products_query = new WP_Query($catalog_products_args);
    ?>


    <div class="catalog js-catalog">
      <?php if ($catalog_products_query->have_posts()) : ?>

        <?php while ($catalog_products_query->have_posts()) : $catalog_products_query->the_post(); ?>
          <?php echo get_template_part('product-content'); ?>
        <?php endwhile; ?>

      <?php endif; ?>

    </div><!-- /.catalog -->

    <div class="section-catalog__footer">
      <a class="link" href="<?php echo get_site_url() . '/products'; ?>">Перейти в каталог</a>
    </div>

  </div>
</section>
<!-- /.section-catalog -->



<?php get_footer(); ?>