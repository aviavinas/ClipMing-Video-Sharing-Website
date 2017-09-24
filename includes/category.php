<?php  
$channel = array(
    array(
        't' => 'Tseries',
        'id' => 'UCq-Fj5jknLsUf-MWSy4_brA',
    ),
    array(
        't' => 'SonyMusicIndiaVevo',
        'id' => 'UC3MLnJtqc_phABBriLRhtgQ',
    ),
    array(
        't' => 'YRF',
        'id' => 'UCbTLwN10NoCU4WDzLf1JMOA',
    ),
    array(
        't' => 'Universal Pictures',
        'id' => 'UCq0OueAsdxH6b8nyAspwViw',
    ),
    array(
        't' => 'Satyamev Jayate',
        'id' => 'UCOAeVVRnqh0sYFKvFo-tERA',
    ),
    array(
        't' => 'Set India',
        'id' => 'UCpEhnqL0y41EpW2TvWAHD7Q',
    ),
    array(
        't' => 'Startup Stories',
        'id' => 'UCnyQy0wD_LCZTlyFHnKIS7Q',
    ),
    array(
        't' => 'ColdFusion',
        'id' => 'UC4QZ_LsYcvcq7qOsOhpAX4A',
    ),
    array(
        't' => 'BBC Hindi',
        'id' => 'UCN7B-QD0Qgn2boVH5Q0pOWg',
    ),
    array(
        't' => 'Narendra Modi',
        'id' => 'UC1NF71EwP41VdjAU1iXdLkw',
    ),
    array(
        't' => 'Alltime10s',
        'id' => 'UCGi_crMdUZnrcsvkCa8pt-g',
    ),
);
?>
<h2>Featured Channel</h2>
<ol type="1">
<?php   
foreach($channel as $ch) {
	$title = $ch['t'];
	$link = '/ClipMing/includes/channel.php?cid='.$ch['id'];
	
	echo ' 
    <li>
      <a href="'.$link.'" class="top-list-a">
        <div class="meta-info">
          <h5 class="song-name">'.$title.'</h5>
        </div>
      </a>
    </li>';
}
?>
</ol>