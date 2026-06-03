<?php
get_header();
global $product;
?>

<main class="single-product-page">
  <div class="container">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

      <div class="single-product-layout">

        <!-- LIJEVO: SLIKA -->
        <div class="single-product-gallery">
          <?php
          if ( has_post_thumbnail() ) {
            echo get_the_post_thumbnail(get_the_ID(), 'large', array(
              'class' => 'single-product-image'
            ));
          }
          ?>
        </div>

        <!-- DESNO: SVE OSTALO -->
        <div class="single-product-summary">

          <h1><?php the_title(); ?></h1>

          <div class="product-actions">
            <form class="cart" method="post" enctype="multipart/form-data">
              <?php woocommerce_quantity_input(); ?>

              <button type="submit"
                name="add-to-cart"
                value="<?php echo esc_attr( $product->get_id() ); ?>"
                class="single_add_to_cart_button">
                Add to cart
              </button>

              <?php
                  $contact_page = get_page_by_path('kontakt');

                  if ($contact_page) {
                      $base_contact_url = get_permalink($contact_page->ID);
                  } else {
                      $base_contact_url = home_url('/kontakt/');
                  }

                  $contact_url = add_query_arg(
                      array(
                          'proizvod' => get_the_title(),
                          'sifra'    => $product->get_sku(),
                          'link'     => get_permalink(),
                      ),
                      $base_contact_url
                  );
                ?>

                <a class="button alt inquiry-button" href="<?php echo esc_url($contact_url); ?>">
                  Pošalji upit
                </a>

              <a href="<?php echo wc_get_cart_url(); ?>" class="cart-link">
                Košarica (<?php echo WC()->cart->get_cart_contents_count(); ?>)
              </a>

            </form>
          </div>

          <?php if ( $product->get_sku() ) : ?>
            <p class="product-sku">
              <strong>Šifra:</strong> <?php echo esc_html( $product->get_sku() ); ?>
            </p>
          <?php endif; ?>

          <div class="product-price">
            <?php echo $product->get_price_html(); ?>
          </div>

          <!-- OPIS SADA DESNO -->
          <div class="single-product-description">
            <h2>Opis proizvoda</h2>
            <?php the_content(); ?>
          </div>

        </div>

      </div>

    <?php endwhile; endif; ?>

  </div>
</main>

<?php get_footer(); ?>