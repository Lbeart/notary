document.addEventListener("DOMContentLoaded", function () { 
    const serviceSelect = document.getElementById("service_type_id");
    const dynamicFields = document.getElementById("dynamicFields");
    const dynamicContent = document.getElementById("dynamicContent");

    const commonFields = `
        <hr>
        <label class="fw-bold">Ngarko dokumentin identifikues (ID ose pasaportë):</label>
        <input type="file" name="identity_document" class="form-control mb-2">

        <label>Ngarko dokument tjetër (opsionale):</label>
        <input type="file" name="additional_document" class="form-control mb-2">

        <label>Fotografi e klientit (opsionale):</label>
        <input type="file" name="client_photo" accept="image/*" class="form-control mb-2">
    `;

    const services = {
        
        "Përpilimi i testamentit": `
            <input type="text" name="heir_name" class="form-control mb-2" placeholder="Emri i trashëgimtarit">
            <input type="text" name="heir_id" class="form-control mb-2" placeholder="Numri personal i trashëgimtarit">
            <textarea name="property_description" class="form-control mb-2" placeholder="Përshkrimi i pasurisë"></textarea>
            <label>Dokument pronësie:</label>
            <input type="file" name="ownership_document" class="form-control mb-2">
        `,
        "Proces-verbali i hapjes së testamentit": `
            <label>Ngarko testamentin origjinal:</label>
            <input type="file" name="testament_file" class="form-control mb-2">
        `,
        "Vërtejimi se personi është gjallë": `
            <input type="text" name="person_name" class="form-control mb-2" placeholder="Emri i personit">
            <input type="text" name="person_id" class="form-control mb-2" placeholder="Numri personal">
        `,
        "Kontrata për transferimin e paluajtshmërivë": `
            <input type="file" name="property_contract" class="form-control mb-2">
            <input type="text" name="buyer_name" class="form-control mb-2" placeholder="Emri i blerësit">
        `,
        "Kontrata për hipotekën e pasurisë së paluajtshme": `
            <input type="file" name="mortgage_document" class="form-control mb-2">
        `,
        "Kontrata për këmbimin e pasurisë së paluajtshme": `
            <input type="file" name="exchange_document" class="form-control mb-2">
        `,
        "Kontrata për qiraje": `
            <input type="text" name="rental_duration" class="form-control mb-2" placeholder="Kohëzgjatja e qirasë">
            <input type="file" name="rental_agreement" class="form-control mb-2">
        `,
        "Heqje dorë nga bashkëpronësia": `
            <input type="file" name="coownership_document" class="form-control mb-2">
        `,
        "Kontrata për pengun e pasurisë së luajtshme": `
            <input type="file" name="pledge_document" class="form-control mb-2">
        `,
        "Kontrata mbi të drejtat pronësore (uzufrukt, servitut)": `
            <input type="file" name="rights_document" class="form-control mb-2">
        `,
        "Përpilimi i akteve të shoqërivë tregtare": `
            <input type="text" name="company_name" class="form-control mb-2" placeholder="Emri i shoqërisë">
            <input type="file" name="company_documents" class="form-control mb-2">
        `,
        "Pjesëmarrje në mbledhje të ortakëve": `
            <input type="text" name="meeting_topic" class="form-control mb-2" placeholder="Tema e mbledhjes">
        `,
        "Vërtejimi i nënshkrimeve në aktet e shoqërivë tregtare": `
            <input type="file" name="signature_doc" class="form-control mb-2">
        `,
        "Vërtejimi i kontratave të punës": `
            <textarea name="job_description" class="form-control mb-2" placeholder="Përshkrimi i punës"></textarea>
            <input type="file" name="employment_contract" class="form-control mb-2">
        `,
        "Autorizimi për tërheqje pensioni": `
            <input type="text" name="authorized_name" class="form-control mb-2" placeholder="Emri i autorizuarit">
            <input type="file" name="id_card" class="form-control mb-2">
        `,
        "Verifikimi i nënshkrimeve": `
            <input type="file" name="signed_document" class="form-control mb-2">
        `,
        "Verifikimi i kontratave": `
            <input type="file" name="contract_to_verify" class="form-control mb-2">
        `,
        "Autorizimi i përgjithshëm": `
            <textarea name="general_purpose" class="form-control mb-2" placeholder="Qëllimi i autorizimit"></textarea>
        `,
        "Autorizimi i posaçëm": `
            <textarea name="specific_purpose" class="form-control mb-2" placeholder="Qëllimi i autorizimit specifik"></textarea>
        `,
        "Vërtejtim i kopjes nga arkiva noteriale": `
            <input type="file" name="original_copy" class="form-control mb-2">
        `,
        "Ekstrakte nga arkiva": `
            <input type="text" name="archive_info" class="form-control mb-2" placeholder="Informacione rreth ekstraktit">
        `,
        "Ruajtje e testamenteve": `
            <input type="file" name="testament_to_store" class="form-control mb-2">
        `,
        "Depozitim i gjësendeve me vlerë (stoli ari, letra me vlerë)": `
            <textarea name="valuable_items" class="form-control mb-2" placeholder="Përshkrimi i sendeve"></textarea>
        `,
        "Përkthim dhe legalizim dokumentesh": `
            <input type="file" name="document_to_translate" class="form-control mb-2">
        `,
        "Legalizim i kontratës së shitjes": `
            <input type="file" name="sales_contract" class="form-control mb-2">
        `,
        "Legalizim i kontratës së dhurimit": `
            <input type="file" name="donation_contract" class="form-control mb-2">
        `,
        "Legalizim i kontratës së qirasë": `
            <input type="file" name="lease_contract" class="form-control mb-2">
        `,
        "Hartim deklarate noteriale": `
            <textarea name="declaration_text" class="form-control mb-2" placeholder="Teksti i deklaratës"></textarea>
        `,
        "Autorizim për udhëtim të fëmijëve": `
            <input type="text" name="child_name" class="form-control mb-2" placeholder="Emri i fëmijës">
            <input type="text" name="destination" class="form-control mb-2" placeholder="Destinacioni i udhëtimit">
            <input type="file" name="child_passport" class="form-control mb-2">
        `,
        "Konfirmim fakti (psh. ekzistenca e një dokumenti apo ngjarjeje)": `
            <textarea name="fact_description" class="form-control mb-2" placeholder="Përshkrimi i faktit"></textarea>
        `,
         "Legalizim (psh. ekzistenca e një dokumenti apo ngjarjeje)": ` 
        <label>Përshkrimi i faktit që po legalizohet:</label>
        <textarea name="legalization_description" class="form-control mb-2" placeholder="Përshkrimi i faktit ose dokumentit që po legalizohet"></textarea>
        <label>Ngarko dokumentin për legalizim:</label>
        <input type="file" name="legalization_document" class="form-control mb-2">
    `,

    "Noterizim i dokumentit": `
        <label>Titulli i dokumentit:</label>
        <input type="text" name="notarization_title" class="form-control mb-2" placeholder="Titulli i dokumentit">
        <label>Ngarko dokumentin që duhet noterizuar:</label>
        <input type="file" name="notarization_file" class="form-control mb-2">
    `,

    "Përkthim i dokumentit": `
        <label>Gjuha e dokumentit:</label>
        <input type="text" name="document_language" class="form-control mb-2" placeholder="P.sh. Anglisht, Gjermanisht">
        <label>Gjuha e përkthimit:</label>
        <input type="text" name="target_language" class="form-control mb-2" placeholder="P.sh. Shqip">
        <label>Ngarko dokumentin për përkthim:</label>
        <input type="file" name="document_to_translate" class="form-control mb-2">
    `,
    };

    serviceSelect.addEventListener("change", function () {
        const selectedText = this.options[this.selectedIndex].text;
        const content = services[selectedText];

        if (content) {
            dynamicContent.innerHTML = content + commonFields;
            dynamicFields.classList.remove("d-none");
        } else {
            dynamicContent.innerHTML = "";
            dynamicFields.classList.add("d-none");
        }
    });
});
  document.addEventListener("DOMContentLoaded", function () {
        const slotSelect = document.getElementById("appointment_slot_id");
        const selectedTimeInput = document.getElementById("selected_time");

        if (slotSelect) {
            slotSelect.addEventListener("change", function () {
                const selectedOption = this.options[this.selectedIndex].text;
                selectedTimeInput.value = selectedOption;
            });
        }
    });