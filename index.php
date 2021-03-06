<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <title>Seasonal Trends</title>

        <link rel='stylesheet' type='text/css' href='resources/styles.css'>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWVVO7YafOX8F-yza4zVOR3zugQEekbGY"
        type="text/javascript"></script>
        <script type="text/javascript" src="resources/script.js"></script>
    </head>

    <body onload="load()">
        <form>
            <div id="filters">

                <?php
                //Configuration details
                require("config.php");

                // Opens a connection to a mySQL server
                @mysql_connect($localhost, $username, $password)
                        or die('Not connected : ' . mysql_error());

                // Set the active mySQL database
                mysql_select_db($database)
                        or die('Can\'t use db : ' . mysql_error());


                echo "<h4>Seasonal Trends </h4>"; // Header
                //Select all distinct states in the businessReviews table
                $result_states = mysql_query($stateQuery);
                if (!$result_states) {
                    die('Invalid query: ' . mysql_error());
                }

                echo "<label>Location: </label><select id=stateValues "
                . "name=drpdwnStateVal onchange=getState()>"; // list box select command

                echo "<option value=Select>Select</option>";
                while ($row = mysql_fetch_row($result_states)) {//Array or records stored in $row
                    echo "<option value=$row[0]>$row[0]</option>";
                }
                echo "</select>"; // Closing of list box
                // Select all distinct seasons in the businessReviews table
                $result_seasons = mysql_query($seasonQuery);
                if (!$result_seasons) {
                    die('Invalid query: ' . mysql_error());
                }

                echo "<br><br><label>Season: </label><select id=seasonValues "
                . "name=drpdwnSeasonVal onchange=getSeason()>"; // list box select command

                echo "<option value=Select>Select</option>";
                while ($row = mysql_fetch_row($result_seasons)) {//Array or records stored in $row
                    echo "<option value=$row[0]>$row[0]</option>";
                }
                echo "</select>"; // Closing of list box


                echo "<br><br><label>Category: </label><select id=categoryValues "
                . "name=drpdwnCategoryVal onchange=getCategory()>"; // list box select command

                echo "<option value=Select>Select</option>";
                echo "<option value=Restaurants>Restaurants</option>";
                echo "<option value=Food>Food</option>";
                echo "<option value=Nightlife>Nightlife</option>";
                echo "<option value=Grocery>Grocery</option>";
                echo "<option value=Shopping>Shopping</option>";
                echo "<option value=Golf>Golf</option>";
                echo "<option value=Fitness>Fitness</option>";
                echo "<option value=Education>Education</option>";
                echo "<option value=Veterinarians>Veterinarians</option>";
                echo "<option value=Pets>Pets</option>";
                echo "<option value=Bars>Bars</option>";
                echo "<option value=Pubs>Pubs</option>";
                echo "<option value=Health & Medical>Health & Medical</option>";
                echo "<option value=Gym>Gym</option>";
                echo "<option value=Hair Salons>Hair Salons</option>";
                echo "<option value=Automotive>Automotive</option>";

                echo "</select><br><br>"; // Closing of list box
                // Select all the rows in the markers table
                $query = "SELECT * FROM businessReviews where city='Phoenix' limit 5";
                $result = mysql_query($query);
                if (!$result) {
                    die('Invalid query: ' . mysql_error());
                }
                ?>

                <input type="button" name="recommend" value="Recommend" id="btnRecommend" 
                       onclick="getRecommendations()"/>

            </div>

            <div id = "tableData">
                <table>
                    <tr>
                        <th>Business Name</th>
                        <th>City</th>
                        <th>Reviews</th>
                        <th>Stars</th>
                    <tr>
                        <td id="businessName"></td>
                        <td id="city"></td>
                        <td id="reviews"></td>
                        <td id="starsDiv">
                            <div class="rating-box">
                                <div class="rating" id="star_rating"></div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="map"></div>

        </form>
    </body>
</html>