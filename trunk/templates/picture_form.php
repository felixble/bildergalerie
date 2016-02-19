<form role="form">

    <div class="row">

        <div class="col-lg-4">
            <h1 >Bild hochladen</h1>
            <input type="file" id="upload_button">
        </div>


        <div class="col-lg-8">

            <h1>Informationen hinzufügen</h1>

            <div class="form-group">
                <label for="title">Titel</label>
                <input type="text" class="form-control" id="title" name="title" />
            </div>
            <div class="form-group">
                <label for="category">Kategorie:</label>
                <select class="form-control" name="category" id="category">
                    <option>-- Bitte wählen --</option>
                    <option>Abstrakt</option>
                    <option>Akt</option>
                    <option>Donnerbalken</option>
                </select>
            </div>
            <div class="form-group">
                <label for="material">Material:</label>
                <input type="text" class="form-control" id="material" name="material" />
            </div>
            <div class="form-group">
                <label for="description">Beschreibung:</label>
                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-success" name="add_pic_submit">Speichern</button>


        </div>

    </div>


</form>