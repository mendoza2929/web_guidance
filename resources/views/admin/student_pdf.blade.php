<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Data Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 5px;
        }
        h1, h2 {
            text-align: center;
            font-size: 14px;
            margin: 0;
        }
        p {
            font-size: 12px;
            text-align: justify;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        td, th {
            border: 1px solid #000;
            padding: 4px;
        }
        .checkbox {
            margin-right: 5px;
        }
        .section-title {
            font-weight: bold;
            text-align: center;
            background-color: #f0f0f0;
        }
        .label {
            font-weight: bold;
            width: 30%;
        }
        .input-field {
            width: 70%;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            border: none;
            /* border-bottom: 1px solid #000; */
            outline: none;
        }
        .signature {
            margin-top: 20px;
            text-align: center;
        }
        .logo {
            position: absolute;
            left: 10px;
            top: 10px;
            width: 15%;
        }
        .title {
            text-align: center;
            margin: 0 150px; /* Space for logo and picture */
            position: absolute;
            left: 15%;
            right: 15%;
            top: 10px;
        }
        .id-picture {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
            position: absolute;
            right: 10px;
            top: 10px;
            display: block;
            text-align: center;
            line-height: 100px; /* Vertically center text */
            font-size: 12px;
        }
        .form-label {
            position: absolute;
            left: 10px;
            bottom: 10px;
            font-size: 12px;
            
        }
    </style>
</head>
<body>
        <img src="{{ asset('assets/img/gallery/asclogo.png') }}" alt="ASC Logo" class="logo">
        <div class="title">
            <h1 style="white-space:nowrap;">ANDRES SORIANO COLLEGES OF BISLIG</h1>
            <h3 style="white-space:nowrap; font-size:14px;">Mangagoy, Bislig City</h3>
            <h1 style="white-space:nowrap;">GUIDANCE TESTING CENTER</h1>
            <br>
            <h2  style="white-space:nowrap; font-size:20px;">PERSONAL DATA SHEET</h2>
        </div>
        <div class="id-picture">
            {{-- 2x2 ID PICTURE --}}
        </div>
      
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p> Guidance Form 1</p>
        <br>
        <p>Dear Students:</p>
        <p>The purpose of this form is to gather information about you which may expect to be of great help to all of us in the Guidance and Counseling processes. The success which you may expect in the counseling will depend on your honest and accurate responses. You don't have to worry; ALL TRANSACTIONS WILL BE KEPT CONFIDENTIAL.</p>
        <div class="container">
        <table>
            <tr>
                <td class="label">NAME:  &nbsp; &nbsp; &nbsp; &nbsp;{{ $student_details->last_name }}  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;{{ $student_details->first_name }}   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{ $student_details->middle_name }}   <br>
                    &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;   (Last Name)&nbsp;&nbsp;&nbsp;     (Given Name) &nbsp;    (Middle Name) &nbsp;  </td>
                    <td class="label">Date: {{ \Carbon\Carbon::now()->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td class="label">ADDRESS: {{ isset($student_details->address) ? $student_details->address : '' }}</td>

                <td style=" font-weight: bold; font-family: DejaVu Sans, sans-serif;">
                    Sex: 
                    ({{ $student_details->gender_id == 1 ? '✓' : ' ' }}) Male 
                    ({{ $student_details->gender_id == 2 ? '✓' : ' ' }}) Female
                </td>
            </tr>
            <tr>
                <td class="label">PLACE OF BIRTH: {{ isset($student_details->place_of_birth) ? $student_details->place_of_birth : '' }}</td>
                <td class="label">Civil Status: {{ isset($student_details->civil_status_name) ? $student_details->civil_status_name : '' }}</td>
            </tr>
            <tr>
                <td class="label">RELIGION: {{ isset($student_details->religion_name) ? $student_details->religion_name : '' }}</td>
                <td class="label">Date of Birth: {{ isset($student_details->birthdate) ? $student_details->birthdate : '' }}</td>
            </tr>
            <tr>
                <td class="label">EMAIL ADDRESS: {{ isset($student_details->email_address) ? $student_details->email_address : '' }}</td>
                <td class="label">Citizenship: {{ isset($student_details->citizenship_name) ? $student_details->citizenship_name : '' }}</td>
            </tr>
            <tr>
                <td class="label"></td>
                <td class="label">Mobile No:{{ isset($student_details->mobile_number) ? $student_details->mobile_number : '' }} </td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="label" style="width: 30%">Are you a working student?</td>
                <td  style=" font-weight: bold; font-family: DejaVu Sans, sans-serif; width:18%;">
                    ({{ $student_details->working_student == 1 ? '✓' : ' ' }}) Yes 
                    ({{ $student_details->working_student == 0 ? '✓' : ' ' }}) No
                </td>
                <td class="label" style="width: 58%"> IF YES, who is your guardian: {{ isset($student_details->guardian) ? $student_details->guardian : '' }} </td>
            </tr>
            <tr>
                <td class="label" style="width: 30%">Are you Scholar?</td>
                <td  style=" font-weight: bold; font-family: DejaVu Sans, sans-serif; width:18%;">
                    ({{ $student_details->scholar == 1 ? '✓' : ' ' }}) Yes 
                    ({{ $student_details->scholar == 0 ? '✓' : ' ' }}) No
                </td>
                <td class="label" style="width: 58%"> IF YES, who is your sponsor: {{ isset($student_details->sponsor) ? $student_details->sponsor : '' }}</td>
            </tr>
            <tr>
                <td class="label" style="width: 30%">Are you a Single Parent</td>
                <td  style=" font-weight: bold; font-family: DejaVu Sans, sans-serif; width:18%;">
                    ({{ $student_details->single_parent == 1 ? '✓' : ' ' }}) Yes 
                    ({{ $student_details->single_parent == 0 ? '✓' : ' ' }}) No
                </td>
                <td class="label" style="width: 58%"> IF YES, how many children do you have:{{ isset($student_details->children) ? $student_details->children : '' }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="label"></td>
            </tr>
        </table>

        <h2>FAMILY BACKGROUND</h2>
        <table>
            <tr>
                <td class="label">No. of Brothers:</td>
                <td class="label">No. of Sisters:</td>
            </tr>
            <tr>
                <td class="label">Father’s Name:</td>
                <td class="label">Mother’s Name:</td>
            </tr>
            <tr>
                <td class="label">Age:</td>
                <td class="label">Age:</td>
            </tr>
            <tr>
                <td class="label">Home Address:</td>
                <td class="label">Home Address:</td>
            </tr>
            <tr>
                <td class="label">Educational Attainment:</td>
                <td class="label">Educational Attainment:</td>
            </tr>
            <tr>
                <td class="label">Occupation:</td>
                <td class="label">Occupation:</td>
            </tr>
            <tr>
                <td class="label">Mobile No:</td>
                <td class="label">Mobile No:</td>
            </tr>
        </table>

        <h2>EDUCATIONAL BACKGROUND</h2>
        <table>
            <tr>
                <th></th>
                <th>Name of School</th>
                <th>Subject like best</th>
                <th>Subject don’t like</th>
            </tr>
            <tr>
                <td class="label" style="text-align: center">Elementary</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td class="label" style="text-align: center">Junior High School Grade 11</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td class="label" style="text-align: center">Grade 12</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td class="label" style="text-align: center">College</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="label">Easiest Subjects:</td>
            </tr>
            <tr>
                <td class="label">Most Difficult Subjects:</td>
            </tr>
            <tr>
                <td class="label">Subjects with Lowest Grades/What Grades:</td>
            </tr>
            <tr>
                <td class="label">Subjects with Highest Grades/What Grades:</td>
            </tr>
            <tr>
                <td class="label">Plan After High School:</td>
            </tr>
            <tr>
                <td class="label">Awards/Honors Received:</td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
        
        <table>
            <tr>
                <td class="label">In case of emergency person to be contacted:</td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
        <div class="signature" style="margin-left: 60%;">
            <p>___________________________________</p>
            <p style="margin-left: 10%;">Sign over printed name of student</p>
        </div>
    </div>
</body>
</html>