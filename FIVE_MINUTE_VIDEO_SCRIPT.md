# 🎙️ Five-Minute Video Presentation Script
## Dry Season Feed & Silage Planner
**Presenter**: Phanuel Niyonkuru  
**Target Duration**: 5 Minutes (0:00 – 5:00)  
**Deliverable**: Video walkthrough for submission field #5

---

## ⏱️ Video Recording Timeline & Script

### 0:00 – 0:50 | Part 1: Title, Introduction & Problem Statement
*🎬 Screen action: Show Slide 1 (Title) or project homepage in browser.*

**What to Say:**
> "Hello everyone. My name is Phanuel Niyonkuru, and today I am presenting my final project: the **Dry Season Feed and Silage Planner**.
>
> In many tropical and semi-arid regions, smallholder dairy farmers face a devastating annual challenge: the dry season. When the rains stop for three to four months, green pastures dry up. This causes milk production to collapse by over 50%, forces emergency livestock selling, and harms farm livelihoods.
>
> The problem is rarely a total lack of grass—it is a lack of **quantitative planning**. Farmers harvest silage without knowing the exact tonnage their herd requires, ignore storage and fermentation losses, and dig pits by guesswork. 
>
> To solve this, I designed and built this web-based decision-support system."

---

### 0:50 – 1:40 | Part 2: Architecture & Technology Stack
*🎬 Screen action: Show Slide 4 (Architecture) or GitHub repository page.*

**What to Say:**
> "Before diving into the live demo, let us look at the architecture.
>
> Rural agricultural usability was my number one priority. Extension officers and farmers frequently operate in areas with weak cellular networks. Therefore, I deliberately avoided heavy, bloated frameworks.
>
> - The **Backend** is built on native **PHP 8+ with Strict Typing** and **PDO** for secure database communication.
> - The **Database** is **MySQL**, cleanly normalized to 3NF with cascading foreign keys to prevent orphaned records.
> - The **Frontend** uses semantic **HTML5 and custom CSS3 Grid**, loading sub-second with zero external CSS frameworks.
> - The **Calculation Engine** runs on vanilla JavaScript for instant client-side responsiveness without page reloads.
>
> All code is version-controlled and public on GitHub."

---

### 1:40 – 3:30 | Part 3: Live Application Walkthrough (The Demo)
*🎬 Screen action: Open browser at `http://localhost/dry_season_feed_planner/`.*

#### Step 3A: Dashboard (1:40 - 2:00)
> "Here is our main dashboard. At a glance, an extension officer sees the overall picture: total registered farmers, recorded animals, total silage conserved, and estimated remaining stock, along with a recent registrations ledger."

#### Step 3B: Register Farmer & Profile Herd (2:00 - 2:30)
*🎬 Screen action: Click on 'Farmers' and 'Herds' navigation tabs.*
> "Let’s register a new farmer under **Farmers**. We enter their name, phone, and district. 
>
> Next, under **Herds**, we record their herd demographics. For instance: 8 lactating cows, 2 dry cows, 3 heifers, and 2 calves. Notice our atomic upsert query—if this farmer's herd changes next month, updating it updates the existing record cleanly without creating duplicate rows."

#### Step 3C: The Silage Calculator (2:30 - 3:15)
*🎬 Screen action: Navigate to 'Silage Calculator'.*
> "Now, the core feature: the **Silage Requirement Calculator**.
>
> When I select our farmer from the dropdown, notice how JavaScript automatically populates the herd numbers instantly.
>
> Now, we define our dry season scenario: 
> - We set the dry season duration to **98 days**.
> - We set expected storage and fermentation loss to **15%**.
> - We click **Calculate target**.
>
> Instantly, the system reveals:
> 1. Our daily fresh silage requirement: **206 kg per day**.
> 2. Total base requirement: **20.19 tonnes**.
> 3. Crucially, our **Gross Target with 15% shrinkage: 23.75 tonnes**. 
>
> Because we model loss by dividing the base by $(1 - 0.15)$, the farmer ensiles enough biomass so that even after 15% fermentation loss, the herd still gets 100% of their ration.
>
> The system also calculates the exact silo pit volume to dig: **36.5 cubic meters**, assuming standard compaction at 650 kg per cubic meter."

#### Step 3D: Inventory Control (3:15 - 3:30)
*🎬 Screen action: Click 'Inventory'.*
> "Once the silage is made or fed, the farmer logs it in **Inventory** under 'made', 'fed', or 'adjustment'. The ledger automatically reconciles net remaining stock across the farm."

---

### 3:30 – 4:20 | Part 4: Security & Technical Rigor
*🎬 Screen action: Briefly show VS Code / GitHub code editor with `config.php` or `herds.php`.*

**What to Say:**
> "From a security standpoint, the application follows industry best practices:
> - **SQL Injection** is completely prevented through 100% parameterized PDO prepared statements.
> - **Cross-Site Scripting (XSS)** is blocked by contextual UTF-8 escaping on every single output using a global helper function.
> - Input validation uses PHP strict type filters to reject negative values or malformed dates."

---

### 4:20 – 5:00 | Part 5: Impact, Future Work & Conclusion
*🎬 Screen action: Show Slide 11 or return to project homepage.*

**What to Say:**
> "In terms of future roadmap:
> - I plan to introduce an **SMS / USSD gateway** so smallholder farmers with basic feature phones can receive weekly feedout alerts.
> - A **Nutritional Ration Balancer** to balance crude protein and energy alongside basal roughage.
>
> In conclusion, the Dry Season Feed & Silage Planner replaces guesswork with science, giving dairy farmers the data-driven certainty they need to protect their herds and livelihoods.
>
> Thank you for watching!"

---

## 💡 Practical Recording Tips for You:
1. **Tool to Record**: Use **OBS Studio** (free), **Clipchamp** (built into Windows 11), or **Loom**.
2. **Audio**: Speak clearly at a moderate pace; keep your microphone close.
3. **Screen Setup**: Keep your browser window zoomed to $110\%$ so text and calculations are crisp and legible in the video.
4. **Link to Submit**: Upload the MP4 video to Google Drive (set to *Anyone with the link can view*) or upload as an *Unlisted* video on YouTube and paste that URL into field #5!
