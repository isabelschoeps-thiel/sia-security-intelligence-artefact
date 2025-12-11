<?php
// API-Schlüssel aus geschützter Datei laden
include('config.php');

// IP2WHOIS SDK laden
require_once __DIR__.'/vendor/autoload.php';

// API-Konfiguration
$config = new \IP2WHOIS\Configuration(IP2WHOIS_API_KEY);
$ip2whois = new \IP2WHOIS\Api($config);

$companyName = "GitHub BUILD FOR A BETTER WORLD";
$userName = "Isabel Schöps Thiel";
$userLocation = "Erfurt, Deutschland";
$userEmails = ["si_foundation@icloud.com", "schoepsisabel@gmail.com"];
$userPhone = "+49 162 1819565";

// Signatur
$signature = "
<strong>$companyName</strong><br>
<strong>$userName</strong><br>
<strong>Standort:</strong> $userLocation<br>
<strong>Email:</strong> " . implode(", ", $userEmails) . "<br>
<strong>Telefon:</strong> $userPhone
";

// Eigene IPv6-Adresse zur WHOIS-Abfrage
$ipv6 = "2a00:20:b004:66d1:7954:61fd:2d13:24cb";

// Liste der Domains zur Abfrage
$domains = [
    "github.com", "github.io", "ethereum.org", "isabelschoeps.com", "developer.apple.com",
    "apple.com", "developer.microsoft.com", "blackrock.com", "pornhub.com", "pornhubpremium.com",
    "bitcoin.com", "bitcoin.org", "openai.com", "dev.google.com", "abc.xyz", "okta.com", "nvidia.com",
    "oracle.com", "saleforces.com", "binance.com", "bitpanda.com", "coinbase.com", "sap.com",
    "cloudflare.com", "godaddy.com", "ionos.com", "wix.com", "revolut.com", "visa.de", "candid.org",
    "dnb.com", "cboe.com", "fortinet.com", "avast.com", "hashicorp.com", "dxc.com",
    "paloaltonetworks.com", "q4inc.com", "roblox.com", "adobe.com", "uber.com", "thelionelectric.com",
    "slack.com", "cloud.com", "zerion.io", "workiva.com", "kraken.com", "jpmorgan.com",
    "crypto.com", "brazzers.xxx", "brazzers.com", "netflix.com", "ngrave.com", "reddit.com",
    "discord.com", "okx.com", "tradingview.com", "wikipedia.com", "mediawiki.com", "canva.com",
    "telegram.com", "gitlab.com", "opensource.com", "opensea.com", "apecoin.com", "etherscan.com",
    "etherscan.io", "linktree.com", "patreon.com", "wordpress.com", "aws.amazon.com", "x.com",
    "gnosischa.in", "codesandbox.io", "hi.com", "kucoin.com", "gitbook.com", "linuxfoundation.org",
    "fujitsu.com", "pytorch.org", "keras.io", "h2o.ai", "opencode.de", "opencode.com", "redhat.com",
    "opensource.com", "oinmastodon.org", "youtube.com", "airbnb.com", "world.org", "linkedin.com",
    "paypal.com", "bisonapp.com", "ethereumclassic.org", "coinmarketcap.com", "coingecko.com",
    "blockcain.com", "wikipedia.org", "onvista.com", "etoro.com", "ishares.com", "frontier.xyz",
    "apecoinmarketplace.com", "unicode.org", "matrix.org", "brew.sh", "git-scm.com", "python.org",
    "hugo.org", "php.net", "mysql.com"
];

// WHOIS-Daten für Domains abrufen
$results = [];
foreach ($domains as $domain) {
    try {
        $results[$domain] = $ip2whois->lookup($domain);
    } catch (Exception $e) {
        $results[$domain] = ["error" => "Fehler: " . $e->getMessage()];
    }
}

// WHOIS-Daten für IPv6-Adresse abrufen (über RIPE WHOIS API)
$ipv6_whois_url = "https://rest.db.ripe.net/search?query-string=" . urlencode($ipv6) . "&flags=no-filtering&source=ripe";
$ipv6_response = file_get_contents($ipv6_whois_url);

if ($ipv6_response === false) {
    $ipv6_data = ["error" => "Fehler bei der Abfrage für IPv6-Adresse"];
} else {
    $ipv6_data = json_decode($ipv6_response, true);
}

// Ergebnisse speichern
$data = [
    "domains" => $results,
    "ipv6" => $ipv6_data
];

file_put_contents("whois_results.json", json_encode($data, JSON_PRETTY_PRINT));

// HTML-Ausgabe (WHOIS)
echo "<html><head><title>WHOIS-Abfrage</title></head><body>";
echo "<h2>WHOIS-Abfrage für ausgewählte Domains & IPv6-Adresse</h2>";
echo "<p>$signature</p>";

// Ausgabe der WHOIS-Daten für Domains
echo "<h3>WHOIS-Ergebnisse für Domains</h3>";
echo "<table border='1'><tr><th>Domain</th><th>Registrar</th><th>Erstellungsdatum</th><th>Ablaufdatum</th></tr>";

foreach ($results as $domain => $data) {
    echo "<tr><td>$domain</td><td>" . ($data['registrar']['name'] ?? 'N/A') . "</td>
          <td>" . ($data['create_date'] ?? 'N/A') . "</td><td>" . ($data['expire_date'] ?? 'N/A') . "</td></tr>";
}
echo "</table>";

// Ausgabe der WHOIS-Daten für die IPv6-Adresse
echo "<h3>WHOIS-Ergebnis für IPv6-Adresse: $ipv6</h3>";
if (isset($ipv6_data['error'])) {
    echo "<p style='color: red;'>Fehler: " . $ipv6_data['error'] . "</p>";
} else {
    echo "<pre>" . json_encode($ipv6_data, JSON_PRETTY_PRINT) . "</pre>";
}

echo "</body></html>";
?>
