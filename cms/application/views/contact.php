<h1>CONTACT</h1>

<h2>Start the conversation.</h2>

<p>We're ready to help bring your vision to life.</p>

<ul>
    <li><a href="tel:<?=$contacts->phone?>"><?=$contacts->phone?></a></li>
    <li><a href="mailto:<?=$contacts->email?>">Email</a></li>
    <li>
        <?=$contacts->address?>
        <p>
            <a href="<?=$contacts->googlemaps?>" target="_blank">GET DIRECTIONS <img src="/images/directions-arrow.png"></a>
        </p>
    </li>
</ul>
