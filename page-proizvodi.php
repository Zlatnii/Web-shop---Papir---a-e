<?php get_header(); ?>

<main>
  <section class="section">
    <div class="container">
      <div class="section-heading">
        <h1>Katalog proizvoda</h1>
        <p>Pregled svih proizvoda dostupnih u webshopu.</p>
      </div>

      <?php
      $terms = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
      ));
      ?>

      <div class="shop-layout">
        <aside class="sidebar">
          <h3>Kategorije</h3>
          <ul id="categoryMenu">
            <li data-category="all" class="active">Sve</li>

            <?php
            if (!is_wp_error($terms) && !empty($terms)) :
              foreach ($terms as $term) :
            ?>
              <li data-category="<?php echo esc_attr($term->slug); ?>">
                <?php echo esc_html($term->name); ?>
              </li>
            <?php
              endforeach;
            endif;
            ?>
          </ul>
        </aside>

        <div class="shop-content">
          <div class="toolbar">
            <input
              type="search"
              id="searchInput"
              placeholder="Pretraži proizvode..."
              aria-label="Pretraži proizvode"
            >

            <select id="categoryFilter" aria-label="Filtriraj po kategoriji">
              <option value="all">Sve kategorije</option>

              <?php
              if (!is_wp_error($terms) && !empty($terms)) :
                foreach ($terms as $term) :
              ?>
                <option value="<?php echo esc_attr($term->slug); ?>">
                  <?php echo esc_html($term->name); ?>
                </option>
              <?php
                endforeach;
              endif;
              ?>
            </select>
          </div>

          <div class="product-grid" id="productGrid">
            <?php
            $args = array(
              'post_type'      => 'product',
              'posts_per_page' => -1,
              'post_status'    => 'publish',
              'orderby'        => 'date',
              'order'          => 'DESC',
            );

            $loop = new WP_Query($args);

            if ($loop->have_posts()) :
              while ($loop->have_posts()) : $loop->the_post();
                global $product;

                $product_terms = get_the_terms(get_the_ID(), 'product_cat');
                $category_slugs = array();
                $category_names = array();

                if ($product_terms && !is_wp_error($product_terms)) {
                  foreach ($product_terms as $product_term) {
                    $category_slugs[] = $product_term->slug;
                    $category_names[] = $product_term->name;
                  }
                }

                $data_category = implode(' ', $category_slugs);
                $display_category = !empty($category_names) ? $category_names[0] : 'Bez kategorije';
            ?>
              <article
                class="product-card"
                data-name="<?php echo esc_attr(strtolower(get_the_title())); ?>"
                data-category="<?php echo esc_attr(strtolower($data_category)); ?>"
              >
                <a href="<?php the_permalink(); ?>" class="product-link">
                  <?php echo woocommerce_get_product_thumbnail(); ?>
                  <h3><b><?php the_title(); ?></b></h3>
                </a>

                <?php if ($product->get_sku()) : ?>
                  <p>Šifra: <?php echo esc_html($product->get_sku()); ?></p>
                <?php endif; ?>

                <p hidden><strong>Kategorija:</strong> <?php echo esc_html($display_category); ?></p>
                <p>Cijena: <strong><?php echo $product->get_price_html(); ?></strong></p>

                <div class="product-buttons">
                  <?php woocommerce_template_loop_add_to_cart(); ?>

                  <a
                    class="button alt"
                    href="<?php echo esc_url(home_url('/kontakt/?proizvod=' . urlencode(get_the_title()) . '&sifra=' . urlencode($product->get_sku()))); ?>"
                  >
                    Pošalji upit
                  </a>
                </div>
              </article>
            <?php
              endwhile;
              wp_reset_postdata();
            else :
              echo '<p>Nema proizvoda za prikaz.</p>';
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>