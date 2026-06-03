<?php
/*
Template Name: Kontakt stranica
*/
get_header();

$success_message = '';
$error_message   = '';

$proizvod = isset($_GET['proizvod']) ? sanitize_text_field(wp_unslash($_GET['proizvod'])) : '';
$sifra    = isset($_GET['sifra']) ? sanitize_text_field(wp_unslash($_GET['sifra'])) : '';
$link     = isset($_GET['link']) ? esc_url_raw(wp_unslash($_GET['link'])) : '';

$ime     = '';
$email   = '';
$telefon = '';
$poruka  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !isset($_POST['stax_kontakt_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(wp_unslash($_POST['stax_kontakt_nonce'])),
            'stax_kontakt_form'
        )
    ) {
        $error_message = 'Sigurnosna provjera nije uspjela. Molimo pokušajte ponovno.';
    } else {
        $ime      = isset($_POST['ime']) ? sanitize_text_field(wp_unslash($_POST['ime'])) : '';
        $email    = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        $telefon  = isset($_POST['telefon']) ? sanitize_text_field(wp_unslash($_POST['telefon'])) : '';
        $poruka   = isset($_POST['poruka']) ? sanitize_textarea_field(wp_unslash($_POST['poruka'])) : '';
        $proizvod = isset($_POST['proizvod']) ? sanitize_text_field(wp_unslash($_POST['proizvod'])) : '';
        $sifra    = isset($_POST['sifra']) ? sanitize_text_field(wp_unslash($_POST['sifra'])) : '';
        $link     = isset($_POST['link']) ? esc_url_raw(wp_unslash($_POST['link'])) : '';

        if (empty($ime) || empty($email) || empty($poruka)) {
            $error_message = 'Molimo ispunite sva obavezna polja.';
        } elseif (!is_email($email)) {
            $error_message = 'Molimo unesite ispravnu e-mail adresu.';
        } else {
            $to = get_option('admin_email');

            $subject = !empty($proizvod)
                ? 'Upit za proizvod: ' . $proizvod
                : 'Novi upit s kontakt stranice';

            $message  = "Zaprimljen je novi upit putem kontakt forme.\n\n";
            $message .= "PODACI O PROIZVODU\n";
            $message .= "-----------------\n";
            $message .= "Naziv proizvoda: " . (!empty($proizvod) ? $proizvod : 'Nije navedeno') . "\n";
            $message .= "Šifra proizvoda: " . (!empty($sifra) ? $sifra : 'Nije navedena') . "\n";
            $message .= "Link proizvoda: " . (!empty($link) ? $link : 'Nije naveden') . "\n\n";

            $message .= "PODACI O KUPCU\n";
            $message .= "--------------\n";
            $message .= "Ime i prezime: " . $ime . "\n";
            $message .= "E-mail: " . $email . "\n";
            $message .= "Telefon: " . (!empty($telefon) ? $telefon : 'Nije naveden') . "\n\n";

            $message .= "PORUKA\n";
            $message .= "------\n";
            $message .= $poruka . "\n";

            $headers = array(
                'Content-Type: text/plain; charset=UTF-8',
                'Reply-To: ' . $ime . ' <' . $email . '>',
            );

            $sent = wp_mail($to, $subject, $message, $headers);

            if ($sent) {
                $success_message = 'Vaš upit je uspješno poslan. Javimo vam se u najkraćem mogućem roku.';

                $ime     = '';
                $email   = '';
                $telefon = '';
                $poruka  = '';
            } else {
                $error_message = 'Došlo je do greške pri slanju poruke. Molimo pokušajte ponovno.';
            }
        }
    }
}
?>

<main>
  <section class="section">
    <div class="container narrow">
      <div class="section-heading">
        <h1>Kontakt</h1>
        <p>Pošaljite upit i odgovorit ćemo vam u najkraćem mogućem roku.</p>
      </div>

      <div class="contact-form">
        <?php if (!empty($success_message)) : ?>
          <p class="form-message" style="color: green;">
            <?php echo esc_html($success_message); ?>
          </p>
        <?php endif; ?>

        <?php if (!empty($error_message)) : ?>
          <p class="form-message" style="color: #dc2626;">
            <?php echo esc_html($error_message); ?>
          </p>
        <?php endif; ?>

        <form method="post" action="">
          <?php wp_nonce_field('stax_kontakt_form', 'stax_kontakt_nonce'); ?>

          <label for="ime">Ime i prezime *</label>
          <input
            type="text"
            id="ime"
            name="ime"
            value="<?php echo esc_attr($ime); ?>"
            required
          >

          <label for="email">E-mail *</label>
          <input
            type="email"
            id="email"
            name="email"
            value="<?php echo esc_attr($email); ?>"
            required
          >

          <label for="telefon">Telefon</label>
          <input
            type="text"
            id="telefon"
            name="telefon"
            value="<?php echo esc_attr($telefon); ?>"
          >

          <label for="proizvod">Proizvod</label>
          <input
            type="text"
            id="proizvod"
            name="proizvod"
            value="<?php echo esc_attr($proizvod); ?>"
            readonly
          >

          <label for="sifra">Šifra proizvoda</label>
          <input
            type="text"
            id="sifra"
            name="sifra"
            value="<?php echo esc_attr($sifra); ?>"
            readonly
          >

          <label for="link_prikaz">Link proizvoda</label>
          <input
            type="text"
            id="link_prikaz"
            value="<?php echo esc_attr($link); ?>"
            readonly
          >

          <input
            type="hidden"
            name="link"
            value="<?php echo esc_attr($link); ?>"
          >

          <label for="poruka">Poruka *</label>
          <textarea
            id="poruka"
            name="poruka"
            rows="6"
            required
          ><?php echo esc_textarea($poruka); ?></textarea>

          <div style="margin-top:18px;">
            <button type="submit" class="btn primary">Pošalji upit</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>