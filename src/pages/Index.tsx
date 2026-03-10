import { useNavigate } from "react-router-dom";
import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Shield, CreditCard, TrendingUp, Smartphone, ArrowRight, ChevronDown, Lock, Phone, FileText, HeadphonesIcon } from "lucide-react";

import heroBanner from "@/assets/hero-banner.jpg";
import sectionPf from "@/assets/section-pf.jpg";
import sectionPj from "@/assets/section-pj.jpg";
import securityBlock from "@/assets/security-block.png";
import appMockup from "@/assets/app-mockup.png";

const Index = () => {
  const navigate = useNavigate();
  const [cpf, setCpf] = useState("");

  const handleCpfSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    navigate(`/cadastro?cpf=${cpf}`);
  };

  return (
    <div className="min-h-screen bg-background font-body">
      {/* Header */}
      <header className="fixed top-0 left-0 right-0 z-50 bg-background/95 backdrop-blur-md border-b border-border">
        <div className="max-w-[1200px] mx-auto px-6 h-16 flex items-center justify-between">
          <div className="flex items-center gap-8">
            <h1 className="text-3xl font-bold nu-text-gradient tracking-tight font-heading cursor-pointer" onClick={() => navigate("/")}>Nu</h1>
            <nav className="hidden lg:flex items-center gap-1">
              {["Conta Digital", "Cartão", "Empresas", "Segurança"].map((item) => (
                <button key={item} className="flex items-center gap-1 px-4 py-2 text-sm font-medium text-foreground hover:text-primary transition-colors rounded-md">
                  {item}
                  <ChevronDown className="h-3.5 w-3.5 text-muted-foreground" />
                </button>
              ))}
            </nav>
          </div>
          <div className="flex items-center gap-3">
            <Button variant="ghost" className="text-sm font-medium" onClick={() => navigate("/login")}>
              Login
            </Button>
            <Button variant="hero" size="sm" onClick={() => navigate("/cadastro")} className="rounded-full px-6">
              Quero ser Nu
            </Button>
          </div>
        </div>
      </header>

      {/* Hero Section — full-width banner */}
      <section className="relative w-full h-[600px] md:h-[700px] overflow-hidden mt-16">
        <img
          src={heroBanner}
          alt="Pessoa sorrindo ao lado de um cachorro"
          className="absolute inset-0 w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-gradient-to-r from-foreground/60 via-foreground/30 to-transparent" />
        <div className="relative z-10 max-w-[1200px] mx-auto px-6 h-full flex items-center">
          <div className="flex flex-col md:flex-row items-start md:items-center justify-between w-full gap-10">
            <div className="max-w-lg">
              <h2 className="text-4xl md:text-5xl lg:text-6xl font-bold text-primary-foreground leading-tight font-heading mb-4">
                Somos incansáveis pra você não precisar ser
              </h2>
              <Button variant="hero" size="lg" className="rounded-full px-8 mt-2" onClick={() => navigate("/cadastro")}>
                Abrir minha conta
              </Button>
            </div>

            {/* CPF Card */}
            <div className="bg-background rounded-2xl p-6 md:p-8 shadow-xl w-full max-w-sm">
              <h3 className="text-lg font-bold text-foreground font-heading mb-1">
                Peça seu Cartão de Crédito e sua Conta Nu
              </h3>
              <form onSubmit={handleCpfSubmit} className="mt-4 space-y-3">
                <Input
                  type="text"
                  placeholder="Digite seu CPF"
                  value={cpf}
                  onChange={(e) => setCpf(e.target.value)}
                  className="h-12 rounded-lg border-border"
                />
                <Button type="submit" variant="hero" className="w-full h-12 rounded-lg flex items-center justify-between px-5">
                  <span>Continuar</span>
                  <ArrowRight className="h-5 w-5" />
                </Button>
              </form>
            </div>
          </div>
        </div>
      </section>

      {/* Product Tabs Section */}
      <section className="py-20 px-6 bg-background">
        <div className="max-w-[1200px] mx-auto">
          <p className="text-sm font-medium text-primary uppercase tracking-widest mb-3">Para cada momento, um Nu diferente</p>
          <div className="grid md:grid-cols-3 gap-6 mt-8">
            {[
              { img: sectionPf, title: "Nu Pessoal", desc: "Conta digital gratuita com cartão, Pix ilimitado e rendimento automático.", cta: "Pessoa Física", link: "/cadastro?tipo=pf" },
              { img: sectionPj, title: "Nu Empresas", desc: "Conta empresarial sem tarifas com gestão financeira completa.", cta: "Pessoa Jurídica", link: "/cadastro?tipo=pj" },
              { img: securityBlock, title: "Nu Premium", desc: "Cartão Black com cashback, pontos e benefícios exclusivos.", cta: "Saiba mais", link: "/cadastro" },
            ].map((card, i) => (
              <div
                key={i}
                className="group relative rounded-2xl overflow-hidden cursor-pointer border border-border hover:border-primary/30 transition-all duration-300"
                onClick={() => navigate(card.link)}
              >
                <div className="aspect-[4/3] overflow-hidden">
                  <img src={card.img} alt={card.title} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                <div className="p-6">
                  <h4 className="text-xl font-bold text-foreground font-heading">{card.title}</h4>
                  <p className="text-sm text-muted-foreground mt-2">{card.desc}</p>
                  <span className="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-primary group-hover:gap-2 transition-all">
                    {card.cta} <ArrowRight className="h-4 w-4" />
                  </span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Features Strip */}
      <section className="py-20 px-6 bg-secondary/50">
        <div className="max-w-[1200px] mx-auto">
          <h3 className="text-3xl md:text-4xl font-bold text-foreground font-heading text-center mb-4">
            O melhor cartão para seu perfil
          </h3>
          <p className="text-center text-muted-foreground max-w-xl mx-auto mb-14">
            Sem anuidade, sem tarifas abusivas e cheio de vantagens.
          </p>
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { icon: CreditCard, title: "Sem anuidade", desc: "Cartão internacional sem cobranças ocultas" },
              { icon: TrendingUp, title: "Rendimento diário", desc: "Seu dinheiro rende mais que a poupança, todo dia" },
              { icon: Shield, title: "100% seguro", desc: "Criptografia avançada e proteção total" },
              { icon: Smartphone, title: "Pix ilimitado", desc: "Transferências instantâneas sem custo algum" },
            ].map((f, i) => (
              <div key={i} className="nu-card rounded-2xl p-6 hover:nu-card-elevated transition-shadow duration-300">
                <div className="w-12 h-12 rounded-xl nu-gradient-bg flex items-center justify-center mb-4">
                  <f.icon className="h-6 w-6 text-primary-foreground" />
                </div>
                <h4 className="font-semibold text-foreground font-heading mb-2">{f.title}</h4>
                <p className="text-sm text-muted-foreground">{f.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* App Section */}
      <section className="py-20 px-6 bg-background">
        <div className="max-w-[1200px] mx-auto grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h3 className="text-3xl md:text-4xl font-bold text-foreground font-heading leading-tight mb-4">
              Um app para tudo.
              <br />
              E tudo no app.
            </h3>
            <p className="text-muted-foreground mb-6 max-w-md">
              Guarde dinheiro de maneira organizada de acordo com seus objetivos. Controle seus gastos, invista e faça Pix — tudo em um só lugar.
            </p>
            <Button variant="hero-outline" className="rounded-full px-6" onClick={() => navigate("/cadastro")}>
              Conheça o App <ArrowRight className="ml-2 h-4 w-4" />
            </Button>
          </div>
          <div className="flex justify-center">
            <img src={appMockup} alt="App Nu mockup" className="w-[320px] md:w-[380px] drop-shadow-2xl" />
          </div>
        </div>
      </section>

      {/* Security Section */}
      <section className="py-20 px-6 nu-gradient-bg">
        <div className="max-w-[1200px] mx-auto grid md:grid-cols-2 gap-12 items-center">
          <div className="flex justify-center">
            <img src={securityBlock} alt="Segurança Nu" className="w-[300px] md:w-[380px] rounded-2xl" />
          </div>
          <div>
            <h3 className="text-3xl md:text-4xl font-bold text-primary-foreground font-heading leading-tight mb-4">
              Segurança é prioridade
            </h3>
            <p className="text-primary-foreground/80 mb-8 max-w-md">
              Estamos aqui para te dar suporte completo e garantir a proteção do seu dinheiro.
            </p>
            <div className="grid grid-cols-2 gap-4">
              {[
                { icon: Lock, label: "Central de Proteção" },
                { icon: Phone, label: "Canais de Atendimento" },
                { icon: FileText, label: "Canal de Denúncias" },
                { icon: HeadphonesIcon, label: "Suporte 24h" },
              ].map((item, i) => (
                <div key={i} className="flex items-center gap-3 bg-primary-foreground/10 backdrop-blur-sm rounded-xl p-3 cursor-pointer hover:bg-primary-foreground/20 transition-colors">
                  <item.icon className="h-5 w-5 text-primary-foreground" />
                  <span className="text-sm font-medium text-primary-foreground">{item.label}</span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* CTA Final */}
      <section className="py-24 px-6 bg-background">
        <div className="max-w-[700px] mx-auto text-center">
          <h3 className="text-3xl md:text-4xl font-bold text-foreground font-heading mb-4">
            Pronto para simplificar sua vida financeira?
          </h3>
          <p className="text-muted-foreground mb-8">
            Abra sua conta digital gratuita em minutos. Sem burocracia, sem taxas escondidas.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button variant="hero" size="lg" onClick={() => navigate("/cadastro?tipo=pf")} className="rounded-full px-10 py-6 text-lg">
              Conta Pessoal <ArrowRight className="ml-2 h-5 w-5" />
            </Button>
            <Button variant="hero-outline" size="lg" onClick={() => navigate("/cadastro?tipo=pj")} className="rounded-full px-10 py-6 text-lg">
              Conta Empresarial
            </Button>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="py-16 px-6 bg-nu-dark text-primary-foreground/70">
        <div className="max-w-[1200px] mx-auto">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-10 mb-12">
            <div>
              <h5 className="text-sm font-bold text-primary-foreground mb-4 font-heading">Transparência</h5>
              <ul className="space-y-2 text-sm">
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Política de privacidade</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Política de segurança</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Termos de Uso</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Contratos</li>
              </ul>
            </div>
            <div>
              <h5 className="text-sm font-bold text-primary-foreground mb-4 font-heading">Explorar</h5>
              <ul className="space-y-2 text-sm">
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Blog</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Comunidade</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Carreiras</li>
              </ul>
            </div>
            <div>
              <h5 className="text-sm font-bold text-primary-foreground mb-4 font-heading">Ajuda</h5>
              <ul className="space-y-2 text-sm">
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Segurança</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Perguntas frequentes</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Contato</li>
              </ul>
            </div>
            <div>
              <h5 className="text-sm font-bold text-primary-foreground mb-4 font-heading">Fale com a gente</h5>
              <ul className="space-y-2 text-sm">
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">4020 0185</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">0800 591 2117</li>
                <li className="hover:text-primary-foreground cursor-pointer transition-colors">Ouvidoria</li>
              </ul>
            </div>
          </div>
          <div className="border-t border-primary-foreground/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <span className="text-2xl font-bold nu-text-gradient font-heading">Nu</span>
            <p className="text-xs text-primary-foreground/50">
              © 2026 NU Bank Virtual. Todos os direitos reservados.
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default Index;
