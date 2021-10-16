<template>
    <app-layout title="Browse Jobs">
        <div class="md:grid md:grid-cols-3 gap-4 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Left Column -->
            <div class="col-span-1 ">

                <div class="bg-white text-grey my-6 sticky top-24 b-2 border-gray-200 shadow-sm">
                    <div class="flex flex-col h-80" id="profile-overview">

                        <div class="flex-grow text-black pt-4 px-2">
                            <p class="float-right"><a class="active" href="#home"
                                                      style="background-color: #26ae61; text-align: center; text-decoration: none; color: white; border-radius: 5px; margin-top: 100px; padding: 12px;"
                                                      id="changeDp">Change Picture</a></p>
                            <p>
                            </p></div>

                        <!--<img src="https://www.ajiriwa.net/uploads/Robssonparker/1549405748_peter robert mgembe pic.jpg"
                             style="width:100%" alt="Avatar">-->
                        <div class="bg-gray-100 bg-opacity-25 text-black px-2">
                            <h2 class="text-3xl">Peter Robert Mgembe</h2>
                        </div>
                    </div>
                    <div class="w3-container pb-3 shadow-md">


                        <div class="text-grey flex py-4 px-2" id="certificateHeader">
                            <span class="flex-grow text-2xl">Certificates</span>
                            <a class="bg-green-500 self-center" id="addcert" href="#addcert">Manage</a>
                        </div>
                        <ul class="list-1 gap-y-4 px-2" style="margin-left: auto; margin-right: auto;">
                            <li class="bullet text-grey flex hover:text-green-500 mt-2">
                                <span class="flex-grow">University-Transcript </span>
                                <a class="button" target="_blank"
                                   href="web/viewer.php?file=University-Transcript_robssonparker.pdf">
                                    <span
                                        class="border-2 text-green-500 px-2 rounded-md border-green-500 hover:bg-green-500 hover:text-white">View</span></a>
                            </li>
                            <li class="bullet w3-text-grey flex hover:text-green-500 mt-2">
                                <span class="flex-grow">A-level-certificate </span>
                                <a class="button" target="_blank"
                                   href="web/viewer.php?file=A-level-certificate_robssonparker.pdf"><span
                                    class="border-2 text-green-500 px-2 rounded-md border-green-500 hover:bg-green-500 hover:text-white">View</span></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- End Left Column -->
            </div>

            <!-- Right Column -->
            <div class="col-span-2">
                <div class="w3-card w3-white w3-margin-bottom">
                    <title>Peter Robert Mgembe Resume</title>
                    <!--<meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://www.ajiriwa.net/css/w3.css">-->

                    <div class="w3-container text-gray-700 body mt-6 bg-white">
                        <div class="">
                            <h1 class="text-center text-3xl ">
                                CURRICULUM VITAE
                            </h1>
                            <p>
                                <strong></strong>
                            </p>
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                PERSONAL PARTICULARS
                            </h2>
                            <div class="px-2">
                            <span>
                            <span style="font-weight: bold">Name</span>
                            <strong>:</strong>
                            Peter Robert Mgembe    </span><br>
                                                <span>
                            <strong>Date </strong>
                            <strong>of </strong>
                            <strong>Birth:</strong>
                            27<sup>th</sup>  January 1994
                        </span><br>
                                                <span>
                            <strong>Nationality:</strong>
                            Tanzanian    </span><br>
                                                <span>
                            <strong>Sex:</strong>
                            Male    </span><br>
                                                <span>
                            <strong>Marital status:</strong>
                            Single    </span><br>
                                                <span>
                            <strong>Phone Number:</strong>
                            +255759867315    </span><br>
                                                <span>
                            <strong>Email Address:</strong>
                            peterrobsson@gmail.com    </span>
                            </div>

                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                PERSONAL PROFILE
                            </h2>
                            <p>
                            </p>
                            <p class="px-2">Experienced <strong>system developer</strong> proficient in PHP and makes projects mainly
                                using Laravel Framework and Vue Js for user interfaces. Have worked with PHP since 2016
                                and
                                have developed various projects one being ajiriwa recruitment platform and a HR
                                Management
                                System. Also comfortable with other languages such as Java and Python.</p>
                            <p></p>
                            <!--<p class="bg-green-500">
          text-white                       <strong>CAREER OBJECTIVES</strong>
                            </p>
                            <p>
                                <strong> </strong>
                            </p>
                            <p>
                                To earn a job that utilizes my skills and experience, to succeed in an
                                environment of growth and excellence, to work hard with full
                                determination and dedication and to achieve personal as well as
                                organizational goals.
                            </p>
                            <p>-->
                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                WORK EXPERIENCE
                            </h2>
                            <div class="px-2">
                            <p>
                                <span style="font-weight: bold">May, 2019 - Oct, 2019 </span><span class="w3-text-green"
                                                                                                   style="font-weight: bold">Global Infosoft Limited</span>
                                : <em>Software Developer</em><strong></strong>
                                <br><span>Worked as a web developer, designed the company website accessible through www.globalsoftwares.net.</span>
                            </p>
                            <p>
                                <span style="font-weight: bold">Jul, 2017 - Aug, 2021 </span><span class="w3-text-green"
                                                                                                   style="font-weight: bold">Ajiriwa Network</span>
                                : <em>Senior System Developer</em><strong></strong>
                                <br><span></span></p>
                            <p>Have worked on multiple projects including recruitment system for the company, HR System
                                as
                                well, Saccos Management system</p>
                            <p></p>
                            </div>
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                EDUCATION AND QUALIFICATIONS
                            </h2>
                            <p class="px-2">
                                <strong>2013 - 2017 </strong><span class="w3-text-green" style="font-weight: bold">Bachelor of Business Administration</span>
                                : <em>Okan University</em><strong></strong>
                            </p>

                        </div>

                        <div>
                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                ACHIEVEMENTS
                            </h2>
                            <div class="px-2">
                            <p><b>Development of ajiriwa.net recruitment platform</b>&nbsp; - with inspration from
                                working
                                at the HR Department at DHL Supply Chain. The platform connects employers and job
                                seekers,
                                assisting employers to get the candidate they need and allowing job seekers to be found,
                                the
                                platform would even assist people in making a professional CV. This CV was create using
                                the
                                platform.<br></p>
                            <p><strong>Development of a payroll management software</strong>&nbsp;which handles a
                                company's
                                payroll and employement management needs. Trial version of the software is live at
                                https://payroll.ajiriwa.net</p>
                            </div>
                        </div>


                        <div>
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                SKILLS
                            </h2>
                        </div>
                        <div class="px-2">
                            <table class="text-gray-700">
                                <tbody>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ Presentation						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ Graphics Design						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ Database Management						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ Web Auditing						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Expert						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ Digital Marketing						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ PHP Programming						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Expert						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ Python						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ Javascript						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ HTML						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ Java						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="215" valign="top">
						<span>
							§ MySQL						</span>
                                    </td>
                                    <td width="215" valign="top">
						<span>
							Advanced						</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!--<div>
                            <p class="bg-green-500">
          text-white                       <strong>COMPUTER AND INFORMATION TECHNOLOGY SKILLS</strong>
                            </p>
                        </div>-->

                        <p>
                        </p>
                        <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                            LANGUAGE PROFICIENCY
                        </h2>
                        <div class="px-2">
                        <p>
                            § English: Advanced
                            <!--<br>Speaking - <em>Advanced</em>, Listening - <em>Advanced</em>, Writing - <em>Advanced</em>, Reading - <em>Advanced</em>-->
                        </p>
                        <p>
                            § Kiswahili: Advanced
                            <!--<br>Speaking - <em>Advanced</em>, Listening - <em>Advanced</em>, Writing - <em>Advanced</em>, Reading - <em>Advanced</em>-->
                        </p>
                        <p>
                            § Turkish: Upper-Intermediate
                            <!--<br>Speaking - <em>Upper-Intermediate</em>, Listening - <em>Professional</em>, Writing - <em>Intermediate</em>, Reading - <em>Upper-Intermediate</em>-->
                        </p>
                        </div>

                        <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                            PERSONAL INTERESTS, HOBBIES AND TALENTS
                        </h2>
                        <div class="px-2"><p><b>Programming </b>- I enjoy coding and spend most of my free time doing so, to solve
                            problems</p>
                            <p><br></p></div>

                        <div>
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                REFEREES
                            </h2>
                        </div>
                        <div class="w3-border-bottom px-2">
                            <p>
                                Apart from my personal information mentioned in this Curriculum Vitae
                                other information with some recommendations may be sought freely from:
                            </p>
                            <p>
                                <strong>Serkan Yardimci</strong>
                            </p>
                            <p>
                                DHL Supply Chain Turkey</p>
                            <p>
                                +905313917352</p>
                            <p>

                            </p>
                            <p>
                                Email: serkan.yardimci@dhl.com</p>

                            <p>
                                <strong>Assoc. Prof. Ezgi Yildirim Saatci</strong>
                            </p>
                            <p>
                                Okan University, Turkey</p>
                            <p>
                                0 (216) 677 16 30 #2364</p>
                            <p>

                            </p>
                            <p>
                                Email: ezgi.saatci@okan.edu.tr</p>

                            <p>
                                <strong>Denis Stephen Mkude</strong>
                            </p>
                            <p>
                                Oriflame Tanzania</p>
                            <p>
                                0755807578</p>
                            <p>

                            </p>
                            <p>
                                Email: dennismkude@yahoo.co.uk</p>

                        </div>
                    </div>


                    <!-- End Right Column -->
                </div>


                <!-- End Grid -->
            </div>

            <!-- End Page Container -->
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";

    export default {
        name: "MyResume",
        components: {
            AppLayout,
        }
    }
</script>

<style scoped>
    #profile-overview {
        background-image: url("https://www.ajiriwa.net/uploads/Robssonparker/1549405748_peter robert mgembe pic.jpg");
        background-size: cover;
    }
</style>
