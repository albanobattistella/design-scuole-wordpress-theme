<?php
global $classe;
// recupero le scuole selezionate
$indirizzi_didattica = dsi_get_option("indirizzi_didattica", "didattica");
//print_r($indirizzi_didattica);
if(is_array($indirizzi_didattica) && count($indirizzi_didattica)>0) {
?>

<section class="section section-padding py-0 bg-bluelectric section-tabs-bg">
    <div class="container">
        <div class="row variable-gutters">
            <div class="col">
                <div class="responsive-tabs-wrapper padding-top-200">
                    <div class="title-large">
                        <h3><?php _e("La didattica", "design_scuole_italia"); ?></h3>
                        <h4 class="text-white label-didattica"><?php _e("la nostra offerta formativa", "design_scuole_italia"); ?></h4>
                    </div><!-- /title-large -->
                    <div class="title-small">
                        <h5><?php _e("L'Istituto", "design_scuole_italia"); ?></h5>
                        <p><?php _e("A.S.", "design_scuole_italia"); ?> <?php echo dsi_convert_anno_scuola(dsi_get_current_anno_scolastico()) ; ?></p>

                    </div><!-- /title-section -->
                    <div class="tabs-img">
                        <img class="img-fluid" src="<?php echo  get_stylesheet_directory_uri(); ?>/assets/img/didattica-mockup.png" title="<?php _e("La didattica", "design_scuole_italia"); ?>" alt="<?php _e("La didattica", "design_scuole_italia"); ?>">
                    </div>
                    <div class="responsive-tabs responsive-tabs-aside padding-bottom-200">
                        <ul>
                            <?php
                            foreach ($indirizzi_didattica as $slugindirizzo){
                                $indirizzo = get_term_by("slug", $slugindirizzo,"percorsi-di-studio");
                                if($indirizzo) {
                                    ?>
                                    <li>
                                        <a href="#tab-<?php echo $slugindirizzo; ?>"><?php echo $indirizzo->name; ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <?php
                        $c=0;
                        foreach ($indirizzi_didattica as $slugindirizzo) {
                        $indirizzo = get_term_by("slug", $slugindirizzo,"percorsi-di-studio");

                        // cerco tutte le strutture associate a questo indirizzo o ai figli
                        $args = array(
                            "post_type" => "struttura",
                            "posts_per_page" => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'percorsi-di-studio',
                                    'field' => 'slug',
                                    'terms' => $slugindirizzo
                                )
                            ),
                            'orderby' => "title",
                            'order' => "ASC"
                        );


                        ?>
                        <div id="tab-<?php echo $slugindirizzo; ?>" class="responsive-tabs-content">
                            <div class="accordion-large accordion-wrapper">

                                <?php

                                // recupero le strutture
                                $strutture = get_posts($args);
                                if($strutture) {
                                    foreach ($strutture as $struttura) {
                                        //  $percorsi_di_studio = dsi_get_meta("link_servizi_didattici", "", $idstruttura);
                                        //  if($percorsi_di_studio){
                                        //      foreach ($percorsi_di_studio as $idpercorso){
//                                                $percorso = get_post($idpercorso);
                                        $descrizione = dsi_get_meta("descrizione", "", $struttura->ID);
                                        $sottotitolo = dsi_get_meta("sottotitolo", "", $struttura->ID);
                                        ?>
                                        <hr/>
                                        <div class="accordion-large-title accordion-header">
                                            <h3><?php echo $struttura->post_title; ?></h3>
                                        </div><!-- /accordion-large-title -->
                                        <div class="accordion-large-content accordion-content">
                                            <?php echo wpautop($descrizione); ?>
                                            <div class="row variable-gutters">
                                                <?php
                                                // controllo se la struttura ha dei percorsi di studio, in caso linko quelli:
                                                $indirizzi = dsi_get_meta("link_servizi_didattici", "", $struttura->ID);
                                                if ($indirizzi) {
                                                    //echo "<div class='col-12'><small><strong>Percorsi di studio</strong></small></div>";
                                                    foreach ($indirizzi as $idindirizzo) {
                                                        ?>
                                                        <div class="col-lg-6  d-flex mb-2 ">
                                                            <a href="<?php echo get_permalink($idindirizzo); ?>"
                                                               class="btn btn-redbrown"
                                                               style="text-decoration:none;"><?php echo get_the_title($idindirizzo); ?></a>
                                                        </div>

                                                        <?php
                                                    }
                                                }  else {
                                                ?>
                                                <div class="col-lg-6 d-flex">

                                                    <a href="<?php echo get_permalink($struttura); ?>"
                                                       class="btn btn-bluelectric"
                                                       style="background-color:#0a00cb; text-decoration:none;"><?php _e("Per saperne di più", "design_scuole_italia"); ?></a>
                                                </div>

                                                <?php
                                                 }
                                                ?>
                                            </div>
                                        </div><!-- /accordion-large-content -->

                                        <?php
                                    }
                                } else{
                                    echo '<div ><h5 class="text-white">';
                                    _e("Nessun istituto associato a questa indirizzo di studi.", "design_scuole_italia");
                                    echo '</h5></div>';
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                            }
                            ?>

                    </div><!-- /responsive-tabs -->
                </div><!-- /responsive-tabs-wrapper -->
            </div><!-- /col -->
        </div><!-- /row -->
    </div><!-- /container -->
</section><!-- /section -->

<?php
}