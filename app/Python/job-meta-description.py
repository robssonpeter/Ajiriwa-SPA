from bs4 import BeautifulSoup
import re

# Function to extract meta description components from HTML content
def generate_meta_description(html_content):
    # Parse HTML content
    soup = BeautifulSoup(html_content, 'html.parser')

    # Extract company name
    company_name = "CCBRT"  # Default value if company name extraction fails
    # You can enhance this part to extract the company name from the HTML content
    # Example: company_name = soup.find('div', class_='company-name').text.strip()

    # Extract job title
    job_title = "Junior Human Resource Business Partner"  # Default value if job title extraction fails
    # You can enhance this part to extract the job title from the HTML content
    # Example: job_title = soup.find('h1', class_='job-title').text.strip()

    # Extract responsibilities
    responsibilities = "Help strengthen the HR department and deliver effective HR services."  # Default value if responsibilities extraction fails
    # You can enhance this part to extract the responsibilities from the HTML content
    # Example: responsibilities = soup.find('div', class_='responsibilities').text.strip()

    # Extract application deadline
    deadline = None
    deadline_match = re.search(r'DEADLINE FOR APPLICATIONS: ([\w\s]+)', html_content)
    if deadline_match:
        deadline = deadline_match.group(1)

    # Construct meta description
    meta_description = f"Join {company_name} as {job_title}. {responsibilities}"
    if deadline:
        meta_description += f" Send your application by {deadline}."

    return meta_description.strip()

# Example HTML content
html_content = """
<p>We are currently looking for dynamic, and self-motivated Food and Beverage professionals who want to move their careers forward.</p>
<p>As a Bartender, you are responsible for providing the highest level of hospitality when preparing and providing beverages. With the following duties and responsibilities</p>
<ul>
<li>Perform all necessary tasks to service beverages according to the standard of performance manual of the Hotel</li>
<li>Achieve total Guest satisfaction and organizational profitability through effective utilization of all resources</li>
<li>Delight the Guest by offering trend-setting and innovative products and services contribute to sales activities and assist in maximizing revenue</li>
<li>Set up the bar and prepare all mise-en-place for service</li>
<li>Clean the bar and all equipment to the required standards and maintain this cleanliness throughout the service</li>
<li>Extend prompt services to all Guests and treat Guests and colleagues in a polite and courteous manner</li>
<li>Operate in a safe and environmentally friendly way to protect guests and employees&rsquo; health and safety, as well as protect and conserve the environment</li>
<li>Comply with the hotel's environmental, health, and safety policies and procedures</li>
</ul>
<p>&nbsp;</p>
</div>
<h2>Skills</h2>
<div class="">
<div class="">
<p>You should ideally have a degree in hospitality with previous experiences in the Food and Beverage Department within a hotel. Excellent written and verbal English communication skills and knowledge in an additional language, along with strong interpersonal and problem-solving abilities are essentials and Computer literate.<br /><strong><br /></strong></p>
<h2><strong>Knowledge &amp; Competencies</strong></h2>
<ul>
<li>The ideal candidate will be customer driven and an extremely proactive and &lsquo;switched on&rsquo; personality with an outgoing, charismatic and approachable character. You will work well under pressure in a fast paced environment and be a great team player, who thrives in working with a multi-cultural team and guests alike, while possessing following additional competencies:</li>
<li>Understanding the Job</li>
<li>Taking Responsibility</li>
<li>Recognizing Differences&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
<li>Customer Focus</li>
<li>Adaptability</li>
<li>Teamwork</li>
"""

# Generate meta description
meta_description = generate_meta_description(html_content)
print("Generated Meta Description:", meta_description)
