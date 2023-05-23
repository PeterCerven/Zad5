<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}

// Generate the PDF
ob_start();
?>

<style>
    .button-blue {
        background-color: #0a4275 !important;
        box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.5);
        transition: 0.4s ease;
    }

    .button-blue:hover {
        background-color: #2576C2 !important;
    }

    .container {
        min-height: 100%;
        margin-bottom: -50px; /* Height of the footer */
        padding-bottom: 50px; /* Height of the footer */
    }
</style>
<x-layout>
    <div class="con d-flex justify-content-center">
        <form id="pdfForm" action="generate-pdf.php" method="POST">
            <button type="submit" class="button-blue text-white rounded py-2 px-4 mt-10">
                <?php echo ($en) ? 'Download PDF' : 'Stiahnuť PDF'; ?>
            </button>
        </form>
    </div>
    <div id="print">
        <div class="container mt-6 mb-6">
            <h1><strong><?php echo ($en) ? 'Introduction:' : 'Úvod:'; ?></strong></h1>
            <p>
                <?php echo ($en) ? 'Welcome to the student user guide for Assignment 5.' : 'Vitajte v študentskej používateľskej príručke pre Zadanie 5.'; ?>
                <br>
                <?php echo ($en) ? 'This guide will walk you through the steps of effectively using the application features as a student.' : 'Táto príručka vás prevedie krokmi, ako efektívne využívať funkcie aplikácie ako študent.'; ?>
            </p><br>
            <h2><strong><?php echo ($en) ? 'System Requirements:' : 'Požiadavky na systém:'; ?></strong></h2>
            <p><?php echo ($en) ? 'Before accessing the application, make sure you have the following:' : 'Pred prístupom k aplikácii sa uistite, že máte nasledujúce:'; ?></p>
            <br>
            <ul>
                <li>
                    <?php echo ($en) ? 'Compatible web browser (e.g., Google Chrome, Mozilla Firefox).' : 'Kompatibilný webový prehliadač (napr. Google Chrome, Mozilla Firefox).'; ?></li>
                <li><?php echo ($en) ? 'Internet connection.' : 'Pripojenie k internetu.'; ?></li>
                <li>
                    <?php echo ($en) ? 'Credentials of your student account provided by your educational institution.' : 'Poverenia študentského účtu poskytnuté vašou vzdelávacou inštitúciou.'; ?></li>
            </ul>
            <br>
            <h2><strong><?php echo ($en) ? 'Accessing the Application:' : 'Prístup k aplikácii:'; ?></strong></h2>
            <p><?php echo ($en) ? 'Open a web browser and enter the application URL.' : 'Otvorte webový prehliadač a zadajte adresu URL aplikácie.'; ?></p>
            <p><?php echo ($en) ? 'On the login page, enter your user email and password.' : 'Na prihlasovacej stránke zadajte svoj používateľský email a heslo.'; ?></p>
            <p><?php echo ($en) ? 'Click the "Login" button to access the application.' : 'Kliknutím na tlačidlo „Prihlásiť“ získate prístup k aplikácii.'; ?></p>
            <br>
            <h2>
                <strong><?php echo ($en) ? 'Application Interface Overview:' : 'Prehľad aplikačného rozhrania:'; ?></strong>
            </h2>
            <p>
                <?php echo ($en) ? 'Navigation menu: Provides information about the logged-in user.' : 'Navigačná ponuka: Poskytuje informácie o tom, kto je prihlásený.'; ?>
                <?php echo ($en) ? 'Access to this guide. Also, options to logout or login.' : 'Prístup k tomuto návodu. Zároveň možnosť odhlásenia alebo prihlásenia.'; ?>
                <br>
                <?php echo ($en) ? 'There is also a back option that allows you to return to the previous page.' : 'Nachádza sa tu aj možnosť späť, ktorou sa viete vrátiť späť na predošlú stránku.'; ?>
            </p>
            <p>
                <?php echo ($en) ? 'To switch between Slovak and English languages, you can find a flag icon in the navigation menu.' : 'Ak chcete prepínať medzi slovenským a anglickým jazykom, v navigácii nájdete vlajočku, kde po kliknutí zmeníte jazyk.'; ?>
                <?php echo ($en) ? 'The application will remain on the current page, but the content will be displayed in the selected language.' : 'Aplikácia zostane na aktuálnej stránke, ale obsah sa zobrazí vo vybranom jazyku.'; ?>
            </p><br>
            <h2><strong><?php echo ($en) ? 'Working on the Page:' : 'Práca na stránke:'; ?></strong></h2>
            <p>
                <?php echo ($en) ? 'After logging in, proceed to the "Student Page" where you can "Generate a New Task" or "View Tasks".' : 'Po prihlásení pokračujte na "stránku študenta", kde si viete "Vygenerovať novú úlohu" alebo "Zobraziť úlohy".'; ?>
                <?php echo ($en) ? 'In the case of generating a new task and switching to "View Tasks", you will find all assigned tasks.' : 'V prípade vygenerovania novej úlohy a prepnutia do "Zobraziť úlohy", kde nájdete všetky pridelené úlohy.'; ?>
                <?php echo ($en) ? 'Here, you can choose which task you want to work on.' : 'Tu si viete vybrať, na ktorej úlohe chcete pracovať.'; ?>
                <?php echo ($en) ? 'After selecting, enter your solution in the provided answer field, and then you just need to submit the completed task.' : 'Po výbere zadajte svoje riešenie do poskytnutého poľa na odpovede a následne vypracovanú úlohu stačí len odovzdať.'; ?>
                <?php echo ($en) ? 'By clicking the "Submit" button, you will submit your solution. Please note that once submitted, the answer cannot be changed!' : 'Kliknutím na tlačidlo "Odovzdať" odošlete svoje riešenie. Pozor, po odovzdaní sa už odpoveď nedá zmeniť!'; ?>
            </p><br>
            <h2><strong><?php echo ($en) ? 'Logging Out:' : 'Odhlásenie:'; ?></strong></h2>
            <p><?php echo ($en) ? 'To log out of the application, click the "Logout" button in the navigation menu.' : 'Pre odhlásenie z aplikácie kliknite na tlačidlo "Odhlásiť" v navigačnom menu.'; ?></p>
            <br>
            <h2><strong><?php echo ($en) ? 'Troubleshooting:' : 'Riešenie problémov:'; ?></strong></h2>
            <p><?php echo ($en) ? 'If you encounter any issues or have any questions while using the application, contact the technical support team for assistance.' : 'Ak pri používaní aplikácie narazíte na nejaké problémy alebo máte nejaké otázky, obráťte sa na tím technickej podpory so žiadosťou o pomoc.'; ?></p>
            <br>
            <h2><strong><?php echo ($en) ? 'Conclusion:' : 'Záver:'; ?></strong></h2>
            <p>
                <?php echo ($en) ? 'Congratulations! You have successfully completed the student guide for Assignment 5.' : 'Gratulujeme! Úspešne ste dokončili študentskú príručku pre aplikáciu Zadanie 5.'; ?>
                <?php echo ($en) ? 'Effectively utilize the application features to generate and submit mathematical problems for evaluation.' : 'Efektívne používajte funkcie aplikácie na generovanie a odosielanie matematických príkladov na hodnotenie.'; ?>
                <?php echo ($en) ? 'If you need further assistance, refer to this guide or contact your teacher or support team for prompt help.' : 'Ak potrebujete ďalšiu pomoc, pozrite si túto príručku alebo kontaktujte svojho učiteľa alebo tím podpory a požiadajte o rýchlu pomoc.'; ?>
            </p>
        </div>
    </div>
</x-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
<script>
    // Submit the form to generate the PDF
    document.getElementById('pdfForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var doc = new jsPDF();
        doc.fromHTML(document.getElementById("print"), 15, 15, {'width': 170});
        doc.save('student_guide.pdf');
    });
</script>
<?php
$pdfContent = ob_get_clean();

// Output the PDF generation code
echo $pdfContent;
?>
