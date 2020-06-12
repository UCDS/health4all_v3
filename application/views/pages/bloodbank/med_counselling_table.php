	<hr>
	<h3>Donor Questionaire</h3>
	<p>(Questions that are faded are to be answered on the day of donation.)</p>
	<table class="counselling-table">
	<tr style="opacity:0.6">
		<td >Do you feel well today? </td>
		<td>
		<input type="radio" value="Yes" name="question1" checked required readonly class="medical_yes" id="yes1" /><label for="yes1">Yes</label>
		<input type="radio" value="No" name="question1" required id="no1" readonly class="medical_no" /><label for="no1">No</label>
		</td>
	</tr>
	<tr style="opacity:0.6">
		<td>Did you have anything to eat in the last 4 hours?  </td>
		<td>
		<input type="radio" value="Yes" name="question2" checked required readonly class="medical_yes" id="yes2" /><label for="yes2">Yes</label>
		<input type="radio" value="No" name="question2" required id="no2" readonly class="medical_no" /><label for="no2">No</label>
		</td>
	</tr>
	<tr style="opacity:0.6">
		<td>Did you sleep well last night? </td>
		<td>
		<input type="radio" value="Yes" name="question3" checked required readonly class="medical_yes" id="yes3" /><label for="yes3">Yes</label>
		<input type="radio" value="No" name="question3" required id="no3" readonly class="medical_no" /><label for="no3">No</label>
		</td>
	</tr>
	<tr>
		<td>Do you have any discomfort during / after donation? </td>
		<td>
		<input type="radio" value="Yes" name="question4" required class="medical_yes" id="yes4" /><label for="yes4">Yes</label>
		<input type="radio" value="No" name="question4" checked required id="no4" class="medical_no" /><label for="no4">No</label>
		</td>
	</tr>
	<tr>
		<td>Have you any reason to believe that you may be infected by either HIV / AIDS, Hepatitis, Malaria and / or Veneral disease? </td>
		<td>
		<input type="radio" value="Yes" name="question5" required class="medical_yes" id="yes5" /><label for="yes5">Yes</label>
		<input type="radio" value="No" name="question5" checked required id="no5" class="medical_no" /><label for="no5">No</label>
		</td>
	</tr>
	<tr>
		<td>In the last 6 months have you had any history of the following?
		<ul>
			<li>Unexplained weight loss</li>
			<li>Repeated Diarrhoea</li>
			<li>Swollen glands</li>
			<li>Continuous low-grade fever</li>
		</ul> </td>
		<td>
		<input type="radio" value="Yes" name="question6" required class="medical_yes" id="yes6" /><label for="yes6">Yes</label>
		<input type="radio" value="No" name="question6" checked required id="no6" class="medical_no" /><label for="no6">No</label>
		</td>
	</tr>
	<tr>
		<td>In the last 6 months have you had any 
		<ul>
			<li>Tattooing</li>
			<li>Accupuncture / Ear piercing</li>
			<li>Dental Extration</li>
		</ul>
		</td>
		<td>
		<input type="radio" value="Yes" name="question7" required class="medical_yes" id="yes7" /><label for="yes7">Yes</label>
		<input type="radio" value="No" name="question7" checked required id="no7" class="medical_no" /><label for="no7">No</label>
		</td>
	</tr>
	<tr>
		<td>In the last 13 months have you had any:
		<ul>
			<li>Immunoglobulin</li>
		</ul>		  
		</td>
		<td>
		<input type="radio" value="Yes" name="question8" required class="medical_yes" id="yes8" /><label for="yes8">Yes</label>
		<input type="radio" value="No" name="question8" checked required id="no8" class="medical_no" /><label for="no8">No</label>
		</td>
	</tr>
	<tr>
		<td>
		<p>Do you suffer or have suffered from any of the following disease? </p>
		<ul style="float:left">
			<li>Heart Disease</li>
			<li>Cancer / Malignant Disease</li>
			<li>Tuberculosis</li>
			<li>Jaundice (last 1 year)</li>
			<li>Typhoid (last 1 year)</li>
			<li>Endocrine Disorder</li>
		</ul>	 
		<ul style="float:left">
			<li>Lung Disease</li>
			<li>Epilepsy</li>
			<li>Abnormal Bleeding Tendency</li>
			<li>Sexually Transmitted Diseases</li>
			<li>Fainting spells</li>
			<li>Poly Cythemia</li>
		</ul>	 
		<ul style="float:left">
			<li>Kidney Disease</li>
			<li>Diabetes</li>
			<li>Allergic Disease</li>
			<li>Malaria (6 months)</li>
			<li>Hepatitis B/C</li>
		</ul>	 
		</td>
		<td>
		<input type="radio" value="Yes" name="question9" required class="medical_yes" id="yes9" /><label for="yes9">Yes</label>
		<input type="radio" value="No" name="question9" checked required id="no9" class="medical_no" /><label for="no9">No</label>
		</td>
	</tr>
	<tr  style="opacity:0.6">
		<td>Are you taking or have taken any of these in the past 72 hours?
		<ul>
			<li>Antibodies</li>
			<li>Steroids</li>
			<li>Aspirin</li>
			<li>Dog Bite / Rabies Vaccine (1 year)</li>
			<li>Alcohol</li>
			<li>Vaccination</li>
		</ul>	
		</td>
		<td>
		<input type="radio" value="Yes" name="question10" required readonly class="medical_yes" id="yes10" /><label for="yes10">Yes</label>
		<input type="radio" value="No" name="question10" checked readonly required id="no10" class="medical_no" /><label for="no10">No</label>
		</td>
	</tr>
	<tr>
		<td>Is there any history of surgery or blood transfusion in the past 6 months?</td>
		<td>
		<input type="radio" value="Yes" name="question11" class="medical_yes" id="yes11" required /><label for="yes11">Yes</label>
		<input type="radio" value="No" name="question11" checked id="no11" class="medical_no" required /><label for="no11">No</label>
		</td>
	</tr>
	<tbody id="women" hidden>
	<tr>
		<td>Are you pregnant?</td>
		<td>
		<input type="radio" value="Yes" name="question12" class="medical_yes" id="yes12" /><label for="yes12">Yes</label>
		<input type="radio" value="No" name="question12" checked id="no12" class="medical_no" /><label for="no12">No</label>
		</td>
	</tr>
	<tr>
		<td>Did you have any abortion in the last 6 months?</td>
		<td> 
		<input type="radio" value="Yes" name="question13" class="medical_yes" id="yes13" /><label for="yes13">Yes</label>
		<input type="radio" value="No" name="question13" checked id="no13" class="medical_no" /><label for="no13">No</label>
		</td>
	</tr>
	<tr>
		<td>Are you breast feeding your child?</td>
		<td> 
		<input type="radio" value="Yes" name="question14" class="medical_yes" id="yes14" /><label for="yes14">Yes</label>
		<input type="radio" value="No" name="question14" checked id="no14" class="medical_no" /><label for="no14">No</label>
		</td>
	</tr>
	<tr>
		<td>Have you taken any Rh Immunoglobulin injection?</td>
		<td>
		<input type="radio" value="Yes" name="question15" class="medical_yes" id="yes15" /><label for="yes15">Yes</label>
		<input type="radio" value="No" name="question15" checked id="no15" class="medical_no" /><label for="no15">No</label>
		</td>
	</tr>
	</tbody>
	<tr>
		<td>Would you like to be informed about any abnormal test result?</td>
		<td>
		<input type="radio" value="Yes" name="question16" required class="medical_yes" id="yes16" /><label for="yes16">Yes</label>
		<input type="radio" value="No" name="question16" required id="no16" class="medical_no" /><label for="no16">No</label>
		</td>
	</tr>
	</table>
	<hr>
	<p>
	<label for="accept_risks">
	<input type="checkbox" value="accept" name="accept" id="accept_risks" required />
		I have accurately answered all the questions and I voluntarily wish to donate blood, I accept the risks associated with this procedure.
		I understand that Blood Donation is totally a voluntary act and no inducement or remuneration has been offered.
		I prohibit any information provided by me or about my donation to be disclosed to any individual or government agency without my prior permission.
	</p></label>
	<hr>
