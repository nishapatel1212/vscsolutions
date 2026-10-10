import sys
import json

price_list = {

    # ---------- DOMESTIC / RESIDENTIAL ----------
    "rewire": {"description": "Rewire house (per room)", "amount": 4500, "category": "domestic"},
    "switchboard": {"description": "Upgrade switchboard", "amount": 900, "category": "domestic"},
    "downlight": {"description": "Install downlight", "amount": 125, "category": "domestic"},
    "powerpoint": {"description": "Install powerpoint (GPO)", "amount": 150, "category": "domestic"},
    "light fitting": {"description": "Install light fitting", "amount": 120, "category": "domestic"},
    "ceiling fan": {"description": "Install ceiling fan", "amount": 220, "category": "domestic"},
    "smoke alarm": {"description": "Install smoke alarm (interconnected)", "amount": 180, "category": "domestic"},
    "safety switch": {"description": "Install safety switch (RCD)", "amount": 220, "category": "domestic"},
    "ev charger": {"description": "Install home EV charging station", "amount": 1800, "category": "domestic"},
    "hot water system": {"description": "Wire electric hot water system", "amount": 350, "category": "domestic"},
    "oven": {"description": "Install/hardwire electric oven", "amount": 200, "category": "domestic"},
    "ceiling exhaust fan": {"description": "Install bathroom exhaust fan", "amount": 250, "category": "domestic"},
    "doorbell": {"description": "Install/wire doorbell", "amount": 100, "category": "domestic"},
    "solar": {"description": "Solar panel system installation", "amount": 6500, "category": "domestic"},
    "battery": {"description": "Home battery storage installation", "amount": 9500, "category": "domestic"},
    "outdoor lighting": {"description": "Install outdoor/garden lighting", "amount": 300, "category": "domestic"},
    "security light": {"description": "Install sensor security light", "amount": 180, "category": "domestic"},
    "intercom": {"description": "Install intercom system", "amount": 400, "category": "domestic"},
    "data point": {"description": "Install data/network point", "amount": 130, "category": "domestic"},
    "antenna": {"description": "Install TV antenna point", "amount": 150, "category": "domestic"},
    "extension lead point": {"description": "Add new circuit for appliance", "amount": 280, "category": "domestic"},

    # ---------- SAFETY / COMPLIANCE ----------
    "safety inspection": {"description": "Electrical safety inspection", "amount": 250, "category": "safety"},
    "compliance certificate": {"description": "Certificate of Electrical Safety (CES)", "amount": 150, "category": "safety"},
    "test and tag": {"description": "Test and tag appliances (per item)", "amount": 8, "category": "safety"},
    "thermal imaging": {"description": "Thermal imaging scan (switchboard)", "amount": 350, "category": "safety"},
    "fault finding": {"description": "Electrical fault finding/diagnosis", "amount": 180, "category": "safety"},
    "emergency callout": {"description": "24/7 emergency callout fee", "amount": 220, "category": "safety"},

    # ---------- COMMERCIAL ----------
    "commercial fitout": {"description": "Commercial electrical fit-out (per sqm)", "amount": 85, "category": "commercial"},
    "office lighting": {"description": "Commercial office lighting installation", "amount": 220, "category": "commercial"},
    "exit lighting": {"description": "Emergency/exit light installation", "amount": 250, "category": "commercial"},
    "commercial switchboard": {"description": "Commercial switchboard upgrade", "amount": 3500, "category": "commercial"},
    "3 phase power": {"description": "Install 3-phase power connection", "amount": 2800, "category": "commercial"},
    "data cabling": {"description": "Commercial data/network cabling", "amount": 180, "category": "commercial"},
    "shop fitout": {"description": "Retail shop electrical fit-out", "amount": 5500, "category": "commercial"},
    "signage wiring": {"description": "Commercial signage wiring/lighting", "amount": 450, "category": "commercial"},
    "hvac wiring": {"description": "Wire HVAC/air conditioning unit", "amount": 600, "category": "commercial"},
    "kitchen wiring": {"description": "Commercial kitchen electrical wiring", "amount": 2200, "category": "commercial"},
    "cctv": {"description": "Install CCTV system", "amount": 1200, "category": "commercial"},
    "access control": {"description": "Install access control/security system", "amount": 1500, "category": "commercial"},
    "generator": {"description": "Backup generator installation", "amount": 4500, "category": "commercial"},

    # ---------- INDUSTRIAL ----------
    "industrial switchboard": {"description": "Industrial switchboard installation", "amount": 8500, "category": "industrial"},
    "motor control": {"description": "Motor control circuit installation", "amount": 1800, "category": "industrial"},
    "machinery wiring": {"description": "Industrial machinery wiring/connection", "amount": 2500, "category": "industrial"},
    "high voltage": {"description": "High voltage installation/connection", "amount": 15000, "category": "industrial"},
    "transformer": {"description": "Transformer installation", "amount": 12000, "category": "industrial"},
    "plc": {"description": "PLC/control system wiring", "amount": 3200, "category": "industrial"},
    "factory lighting": {"description": "Industrial/warehouse lighting upgrade", "amount": 6500, "category": "industrial"},
    "conduit run": {"description": "Industrial conduit installation (per meter)", "amount": 45, "category": "industrial"},
    "cable tray": {"description": "Install cable tray system (per meter)", "amount": 60, "category": "industrial"},
    "earthing system": {"description": "Industrial earthing/grounding system", "amount": 3500, "category": "industrial"},
}

def generate_quote(job_description):
    job_description = job_description.lower()
    items = []
    for keyword, details in price_list.items():
        if keyword in job_description:
            items.append({
                "description": details["description"],
                "quantity": 1,
                "amount": details["amount"]
            })
    return items

if __name__ == "__main__":
    job_description = sys.argv[1]  # gets text passed in from Laravel
    result = generate_quote(job_description)
    print(json.dumps({"items": result}))