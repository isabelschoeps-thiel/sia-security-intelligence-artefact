<?php
// === PERSONALISIERTE EINSTELLUNGEN ===
$companyName = "GitHub BUILD FOR A BETTER WORLD";
$userName = "Isabel Schöps Thiel";
$userLocation = "Erfurt, Deutschland";
$userEmails = ["si_foundation@icloud.com", "schoepsisabel@gmail.com"];

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

// API-Schlüssel (sicher speichern, z. B. in einer Umgebungsvariable)
$apiKey = '825F110DD33DDAA0ACFEA9F0BF8FBA7E';

// === FUNKTION: WHOIS-API ANFRAGE ===
function getWhoisData($domain, $apiKey) {
    $url = "https://api.ip2whois.com/v2?key=" . urlencode($apiKey) . "&domain=" . urlencode($domain) . "&format=json";

    // cURL-Anfrage vorbereiten
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // API-Abfrage ausführen
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    // Fehlerbehandlung
    if ($response === false) {
        return ["error" => "Fehler bei der API-Anfrage: $error"];
    } elseif ($httpCode !== 200) {
        return ["error" => "API-Fehler: HTTP-Statuscode $httpCode"];
    }

    // JSON dekodieren
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return ["error" => "Fehler beim Dekodieren der JSON-Daten: " . json_last_error_msg()];
    }

    return $data;
}

// === START: ABFRAGE FÜR ALLE DOMAINS ===
$results = [];
foreach ($domains as $domain) {
    echo "Abfrage für: $domain läuft...\n";
    $results[$domain] = getWhoisData($domain, $apiKey);
}

// === SPEICHERN DER ERGEBNISSE IN EINER DATEI ===
$filename = "whois_results_" . date("Y-m-d_H-i-s") . ".json";
file_put_contents($filename, json_encode($results, JSON_PRETTY_PRINT));

echo "\nAlle WHOIS-Daten gespeichert in: $filename\n";

// === AUSGABE DER ERGEBNISSE (HTML-Tabelle für bessere Übersicht) ===
echo "<html><head><title>WHOIS-Abfrage</title></head><body>";
echo "<h2>WHOIS-Abfrage für ausgewählte Domains</h2>";
echo "<p>Unternehmen: <b>$companyName</b></p>";
echo "<p>Name: <b>$userName</b> | Standort: <b>$userLocation</b></p>";
echo "<p>Email: <b>" . implode(", ", $userEmails) . "</b></p>";
echo "<table border='1' cellpadding='5'><tr><th>Domain</th><th>Registrar</th><th>Erstellungsdatum</th><th>Ablaufdatum</th></tr>";

foreach ($results as $domain => $data) {
    if (isset($data['error'])) {
        echo "<tr><td>$domain</td><td colspan='3' style='color:red;'>Fehler: " . $data['error'] . "</td></tr>";
    } else {
        echo "<tr>
                <td>$domain</td>
                <td>" . ($data['registrar']['name'] ?? 'N/A') . "</td>
                <td>" . ($data['create_date'] ?? 'N/A') . "</td>
                <td>" . ($data['expire_date'] ?? 'N/A') . "</td>
              </tr>";
    }
}

echo "</table></body></html>";
?>
